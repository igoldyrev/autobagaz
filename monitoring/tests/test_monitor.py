import importlib.util
import json
from pathlib import Path
import tempfile
import unittest
from unittest.mock import patch

SPEC = importlib.util.spec_from_file_location('monitor', Path(__file__).parents[1] / 'monitor.py')
monitor = importlib.util.module_from_spec(SPEC)
SPEC.loader.exec_module(monitor)


class MonitorTest(unittest.TestCase):
    def test_thresholds_flapping_hourly_reminder_and_independent_delivery(self):
        state = {}
        for now in (0, 60):
            monitor.advance(state, False, 'HTTP 503', now)
            self.assertIsNone(monitor.due(state, '1', now))
        monitor.advance(state, True, '', 120)
        for now in (180, 240, 300):
            monitor.advance(state, False, 'HTTP 503', now)
        self.assertEqual('down', monitor.due(state, '1', 300))
        state['delivery'] = {'1': {'down': True, 'at': 300}}
        self.assertIsNone(monitor.due(state, '1', 3599))
        self.assertEqual('down', monitor.due(state, '2', 3599))
        self.assertEqual('down', monitor.due(state, '1', 3900))
        monitor.advance(state, True, '', 3960)
        self.assertTrue(state['down'])
        monitor.advance(state, True, '', 4020)
        self.assertEqual('recovery', monitor.due(state, '1', 4020))
        self.assertIsNone(monitor.due(state, '2', 4020))

    def test_startup_health_and_outage_resolved_before_delivery_do_not_notify(self):
        state = monitor.advance({}, True, '', 0)
        self.assertIsNone(monitor.due(state, '1', 0))
        for now in (60, 120, 180):
            monitor.advance(state, False, 'TLS error', now)
        for now in (240, 300):
            monitor.advance(state, True, '', now)
        self.assertIsNone(monitor.due(state, '1', 300))

    def test_freshness_rejects_missing_naive_future_and_boundary_timestamps(self):
        now = monitor.timestamp('2026-11-03T12:00:00Z')
        for value in (None, 'broken', '2026-11-03T12:00:00',
                      '2026-11-03T12:01:01Z', '2026-11-03T11:45:00Z'):
            with self.subTest(value=value), self.assertRaises(monitor.CheckError):
                monitor.fresh(value, now, 900)
        monitor.fresh('2026-11-03T16:59:00+05:00', now, 900)

    def test_collector_uses_attempt_not_source_state_or_last_success(self):
        target = {'url': 'https://site.test/', 'heartbeat_url': 'https://site.test/heartbeat', 'token': 'secret'}
        now = monitor.timestamp('2026-11-03T12:00:00Z')
        payload = {'schema_version': '1.0', 'source': 'igoldyrev-collector', 'enabled': True,
                   'generated_at': '2026-11-03T12:00:00Z', 'last_attempt_at': '2026-11-03T11:55:00Z'}
        with patch.object(monitor, 'request', side_effect=[None, payload]):
            monitor.check(target, now)
        for updates in ({'enabled': False}, {'last_attempt_at': None},
                        {'last_attempt_at': '2026-11-03T11:45:00Z'}, {'source': 'wrong'},
                        {'generated_at': '2026-11-03T11:50:00Z'}):
            with self.subTest(updates=updates), patch.object(monitor, 'request', side_effect=[None, payload | updates]):
                with self.assertRaises(monitor.CheckError):
                    monitor.check(target, now)

    def test_redirects_never_forward_bearer_token(self):
        self.assertIsNone(monitor.NoRedirect().redirect_request(None, None, 302, '', {}, 'https://other.test/'))

    def test_connection_errors_do_not_leak_secrets(self):
        with patch.object(monitor.HTTP, 'open', side_effect=OSError('https://api.telegram.org/botSECRET/sendMessage')):
            with self.assertRaises(monitor.CheckError) as caught:
                monitor.request('https://example.test/')
            self.assertNotIn('SECRET', str(caught.exception))

    def test_delivery_persists_across_restart(self):
        with tempfile.TemporaryDirectory() as directory:
            path = Path(directory) / 'state.json'
            state = {'a': {'down': True, 'delivery': {'1': {'down': True, 'at': 100}}}}
            monitor.save(path, state)
            restored = json.loads(path.read_text())
            self.assertIsNone(monitor.due(restored['a'], '1', 160))
            self.assertEqual('down', monitor.due(restored['a'], '2', 160))

    def test_failed_recipient_is_retried_without_duplicate_for_successful_recipient(self):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            config = root / 'config.json'
            config.write_text(json.dumps({'telegram_bot_token': 'secret', 'telegram_chat_ids': ['1', '2'],
                'targets': [{'id': 'a', 'name': 'A', 'url': 'https://a.test/'},
                            {'id': 'b', 'name': 'B', 'url': 'https://b.test/'}]}))
            args = ['monitor', '--config', str(config), '--state-dir', str(root / 'state')]
            def probe(target, now):
                if target['id'] == 'a':
                    raise monitor.CheckError('HTTP 503')
            with patch.object(monitor, 'check', side_effect=probe), patch('sys.argv', args), patch.object(monitor, 'send') as send:
                monitor.main()
                monitor.main()
                send.side_effect = [None, monitor.CheckError('Telegram failed')]
                self.assertEqual(1, monitor.main())
                self.assertEqual(['1', '2'], [call.args[1] for call in send.call_args_list])
                send.reset_mock(side_effect=True)
                self.assertEqual(0, monitor.main())
                self.assertEqual(['2'], [call.args[1] for call in send.call_args_list])


if __name__ == '__main__':
    unittest.main()
