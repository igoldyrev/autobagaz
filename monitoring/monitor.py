#!/usr/bin/env python3
"""Independent availability/collector monitor. Python 3.10+, standard library only."""

import argparse
import contextlib
import datetime as dt
import fcntl
import json
import os
from pathlib import Path
import sys
import time
import urllib.error
import urllib.request
from urllib.parse import urlsplit

UTC = dt.timezone.utc
MAX_BODY = 65536


class CheckError(Exception):
    """Safe, credential-free diagnostic suitable for logs and alerts."""


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None


# Do not inherit proxy environment variables or forward credentials on redirects.
HTTP = urllib.request.build_opener(urllib.request.ProxyHandler({}), NoRedirect())


def request(url, *, token=None, payload=None, read_json=True):
    headers = {'User-Agent': 'Autobagaz-External-Monitor/1.0', 'Accept': 'application/json'}
    if token:
        headers['Authorization'] = 'Bearer ' + token
    data = None
    if payload is not None:
        data = json.dumps(payload).encode()
        headers['Content-Type'] = 'application/json'
    try:
        req = urllib.request.Request(url, data=data, headers=headers)
        with HTTP.open(req, timeout=8) as response:
            if response.status != 200:
                raise CheckError('HTTP ' + str(response.status))
            if not read_json:
                return None
            body = response.read(MAX_BODY + 1)
            if len(body) > MAX_BODY:
                raise CheckError('Слишком большой ответ API')
            result = json.loads(body)
            if not isinstance(result, dict):
                raise CheckError('Некорректный ответ API')
            return result
    except urllib.error.HTTPError as error:
        raise CheckError('HTTP ' + str(error.code)) from None
    except (OSError, ValueError, urllib.error.URLError):
        # Exception text may contain the bot token, URL or response body.
        raise CheckError('Ошибка подключения, TLS или формата ответа') from None


def timestamp(value):
    if not isinstance(value, str):
        raise CheckError('Нет корректной временной отметки')
    try:
        parsed = dt.datetime.fromisoformat(value.replace('Z', '+00:00'))
        if parsed.tzinfo is None:
            raise ValueError()
        return parsed.timestamp()
    except (ValueError, OverflowError):
        raise CheckError('Некорректная временная отметка') from None


def fresh(value, now, max_age):
    age = now - timestamp(value)
    if age < -60:
        raise CheckError('Временная отметка из будущего')
    if age >= max_age:
        raise CheckError('Временная отметка устарела')


def check(target, now):
    request(target['url'], read_json=False)
    if target.get('heartbeat_url'):
        payload = request(target['heartbeat_url'], token=target['token'])
        if payload.get('schema_version') != '1.0' or payload.get('source') != 'igoldyrev-collector':
            raise CheckError('Неизвестный формат heartbeat')
        fresh(payload.get('generated_at'), now, 180)
        if payload.get('enabled') is not True:
            raise CheckError('Сборщик отключён')
        # last_attempt_at advances after both successful and failed source polls.
        # Source degradation is handled by the existing internal monitoring.
        try:
            fresh(payload.get('last_attempt_at'), now, 900)
        except CheckError:
            raise CheckError('Нет свежего запуска сборщика за последние 15 минут') from None


def advance(state, healthy, reason, now):
    state['failures'] = 0 if healthy else min(state.get('failures', 0) + 1, 3)
    state['successes'] = min(state.get('successes', 0) + 1, 2) if healthy else 0
    if not healthy:
        state['reason'] = reason
    if state['failures'] >= 3 and not state.get('down', False):
        state.update(down=True, since=now)
    elif state['successes'] >= 2:
        state['down'] = False
    return state


def due(state, recipient, now):
    delivered = state.get('delivery', {}).get(recipient, {})
    if state.get('down', False):
        if delivered.get('down') is not True or now - delivered.get('at', 0) >= 3600:
            return 'down'
    elif delivered.get('down') is True:
        return 'recovery'
    return None


def save(path, state):
    temporary = path.with_suffix('.tmp')
    with temporary.open('w') as stream:
        json.dump(state, stream, ensure_ascii=False)
        stream.flush()
        os.fsync(stream.fileno())
    temporary.replace(path)


def send(config, recipient, text):
    payload = request('https://api.telegram.org/bot' + config['telegram_bot_token'] + '/sendMessage',
                      payload={'chat_id': recipient, 'text': text,
                               'link_preview_options': {'is_disabled': True}})
    if payload.get('ok') is not True:
        raise CheckError('Telegram не подтвердил доставку')


def load_config(path):
    config = json.loads(path.read_text())
    if not isinstance(config.get('telegram_bot_token'), str) or not config['telegram_bot_token']:
        raise ValueError('Missing Telegram token')
    recipients = config.get('telegram_chat_ids')
    if not isinstance(recipients, list) or not 1 <= len(recipients) <= 10:
        raise ValueError('Expected 1–10 Telegram recipients')
    if any(not isinstance(item, str) or not item.lstrip('-').isdigit() for item in recipients):
        raise ValueError('Invalid Telegram recipients')
    targets = config.get('targets')
    if not isinstance(targets, list) or len(targets) != 2:
        raise ValueError('Expected two targets')
    ids = set()
    for target in targets:
        if not isinstance(target.get('id'), str) or not target['id'] or target['id'] in ids:
            raise ValueError('Invalid target ID')
        ids.add(target['id'])
        if not isinstance(target.get('name'), str) or not target['name']:
            raise ValueError('Missing target name')
        for key in ('url', 'heartbeat_url'):
            if key == 'heartbeat_url' and key not in target:
                continue
            url = urlsplit(target[key])
            if url.scheme != 'https' or not url.hostname or url.username or url.password or url.query or url.fragment:
                raise ValueError('Expected HTTPS URL without credentials or query')
        if target.get('heartbeat_url') and not target.get('token'):
            raise ValueError('Missing heartbeat token')
    return config


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--config', type=Path, required=True)
    parser.add_argument('--state-dir', type=Path, default=Path('/var/lib/autobagaz-monitor'))
    parser.add_argument('--check', action='store_true', help='Check endpoints without saving state or sending Telegram')
    parser.add_argument('--test-notification', action='store_true', help='Send one explicit setup test to each recipient')
    args = parser.parse_args()
    os.umask(0o077)
    with contextlib.ExitStack() as stack:
        config = load_config(args.config)
        if args.test_notification:
            for recipient in config['telegram_chat_ids']:
                send(config, recipient, 'Внешний монитор: тест доставки с Aeza. Проверки обоих сайтов и свежести сборщика настроены.')
            print('Telegram test delivered', flush=True)
            return 0
        state = {}
        if not args.check:
            args.state_dir.mkdir(parents=True, exist_ok=True)
            lock = stack.enter_context((args.state_dir / 'monitor.lock').open('a'))
            try:
                fcntl.flock(lock, fcntl.LOCK_EX | fcntl.LOCK_NB)
            except BlockingIOError:
                print('Another monitor is running', flush=True)
                return 0
            path = args.state_dir / 'state.json'
            if path.exists():
                # Fail visibly on corruption instead of silently losing delivery state.
                state = json.loads(path.read_text())
        failed = False
        delivery_failed = False
        for target in config['targets']:
            now = time.time()
            reason = ''
            try:
                check(target, now)
                healthy = True
            except CheckError as error:
                healthy = False
                reason = str(error)
                failed = True
            print(target['id'] + ': ' + ('ok' if healthy else reason), flush=True)
            if args.check:
                continue
            current = advance(state.setdefault(target['id'], {}), healthy, reason, now)
            save(path, state)
            for recipient in dict.fromkeys(config['telegram_chat_ids']):
                event = due(current, recipient, now)
                if event is None:
                    continue
                if event == 'down':
                    text = 'Внешний монитор: ' + target['name'] + ' — проблема.\n' + current['reason']
                else:
                    text = 'Внешний монитор: ' + target['name'] + ' — работа восстановлена.'
                text += '\n' + dt.datetime.fromtimestamp(now, UTC).isoformat(timespec='seconds')
                try:
                    send(config, recipient, text)
                except CheckError:
                    print('Telegram delivery failed; will retry on next run', file=sys.stderr, flush=True)
                    delivery_failed = True
                    continue
                current.setdefault('delivery', {})[recipient] = {'down': event == 'down', 'at': now}
                save(path, state)
        # An outage is a completed check, not a service execution failure.
        return int(failed if args.check else delivery_failed)


if __name__ == '__main__':
    try:
        sys.exit(main())
    except Exception:
        print('Monitor failed: check configuration, permissions and state file', file=sys.stderr)
        sys.exit(1)
