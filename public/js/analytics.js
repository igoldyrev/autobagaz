(() => {
    const configElement = document.getElementById('metrika-config');
    if (!configElement) return;

    const config = JSON.parse(configElement.textContent);
    const counterId = Number(config.counterId);
    if (!Number.isSafeInteger(counterId) || counterId <= 0) return;

    const cookieName = 'autobagaz_analytics_consent';
    const version = 'v1';
    const maxAge = 30 * 24 * 60 * 60;
    const notice = document.querySelector('[data-cookie-notice]');
    const status = document.querySelector('[data-analytics-status]');
    const closeButton = document.querySelector('[data-analytics-close]');
    const settingButtons = document.querySelectorAll('[data-analytics-settings]');
    const goals = new Set(['contact_phone', 'contact_email', 'installation_booking_opened', 'callback_sent', 'order_created']);
    let initialized = false;
    let loading = false;
    const pendingEvents = [];

    const readChoice = () => {
        const value = document.cookie.split('; ').find((item) => item.startsWith(`${cookieName}=`));
        if (!value) return null;
        try {
            const [savedVersion, choice, timestamp] = decodeURIComponent(value.slice(cookieName.length + 1)).split(':');
            const age = Date.now() / 1000 - Number(timestamp);
            if (savedVersion !== version || !['accepted', 'rejected'].includes(choice)
                || !timestamp || !Number.isFinite(age) || age < -60 || age >= maxAge) return null;
            return choice;
        } catch {
            return null;
        }
    };
    const allowed = () => readChoice() === 'accepted';
    // Goals that happened before consent are never replayed after accepting.
    let pendingGoal = allowed() && goals.has(config.goal) ? config.goal : null;
    const pendingParams = pendingGoal === 'order_created' && Number.isFinite(config.params?.order_price)
        ? { order_price: config.params.order_price, currency: 'RUB' } : undefined;

    const protectFields = () => {
        document.querySelectorAll('input, textarea, select').forEach((field) => field.classList.add('ym-disable-keys'));
    };
    const reachGoal = (name, params) => {
        if (!allowed() || !goals.has(name)) return;
        const safeParams = name === 'order_created' && Number.isFinite(params?.order_price)
            ? { order_price: params.order_price, currency: 'RUB' } : undefined;
        if (initialized) window.ym(counterId, 'reachGoal', name, safeParams);
        else if (loading) pendingEvents.push([name, safeParams]);
    };
    const start = () => {
        if (!allowed() || initialized || loading) return;
        protectFields();
        window[`disableYaCounter${counterId}`] = false;
        loading = true;
        window.ym = window.ym || function () { (window.ym.a = window.ym.a || []).push(arguments); };
        window.ym.l = Date.now();
        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://mc.yandex.ru/metrika/tag.js';
        script.onload = () => {
            loading = false;
            if (!allowed()) return;
            protectFields();
            window.ym(counterId, 'init', {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true,
                disableYtm: true,
            });
            initialized = true;
            if (pendingGoal) reachGoal(pendingGoal, pendingParams);
            pendingGoal = null;
            for (const [name, params] of pendingEvents.splice(0)) reachGoal(name, params);
        };
        script.onerror = () => { loading = false; script.remove(); };
        document.head.append(script);
    };
    const clearAnalyticsCookies = () => {
        const domains = [null];
        const parts = window.location.hostname.split('.');
        for (let i = 0; i < parts.length - 1; i++) domains.push(`.${parts.slice(i).join('.')}`);
        for (const item of document.cookie.split('; ')) {
            const name = item.split('=')[0];
            if (!name.startsWith('_ym_')) continue;
            for (const domain of domains) {
                document.cookie = `${name}=; Max-Age=0; Path=/; SameSite=Lax${domain ? `; Domain=${domain}` : ''}`;
            }
        }
    };
    const stop = () => {
        window[`disableYaCounter${counterId}`] = true;
        pendingGoal = null;
        pendingEvents.length = 0;
        if (initialized) window.ym(counterId, 'destruct');
        if (window.ym?.a) window.ym.a.length = 0;
        clearAnalyticsCookies();
        // Reload unloads Webvisor and any already loaded library after withdrawal.
        if (initialized || loading) window.location.reload();
    };
    const showNotice = () => {
        if (!notice) return;
        notice.hidden = false;
        if (closeButton) closeButton.hidden = readChoice() === null;
        if (status) status.textContent = allowed() ? 'Сейчас аналитика разрешена.'
            : readChoice() === 'rejected' ? 'Сейчас аналитика отключена.' : '';
    };
    const choose = (choice) => {
        const value = `${version}:${choice}:${Math.floor(Date.now() / 1000)}`;
        document.cookie = `${cookieName}=${encodeURIComponent(value)}; Max-Age=${maxAge}; Path=/; SameSite=Lax${window.location.protocol === 'https:' ? '; Secure' : ''}`;
        if (readChoice() !== choice) {
            if (status) status.textContent = 'Не удалось сохранить выбор. Аналитика остаётся отключённой. Разрешите технические cookie и попробуйте снова.';
            stop();
            return;
        }
        try { window.localStorage.setItem(cookieName, value); } catch { /* Cookie is authoritative. */ }
        if (notice) notice.hidden = true;
        if (choice === 'accepted') start();
        else stop();
    };
    const synchronize = () => {
        if (allowed()) start();
        else {
            stop();
            if (readChoice() === null) showNotice();
        }
    };

    window.autobagazAnalytics = { reachGoal };
    protectFields();
    new MutationObserver(protectFields).observe(document.body, { childList: true, subtree: true });
    settingButtons.forEach((button) => {
        button.hidden = false;
        button.addEventListener('click', showNotice);
    });
    document.querySelector('[data-analytics-accept]')?.addEventListener('click', () => choose('accepted'));
    document.querySelector('[data-analytics-reject]')?.addEventListener('click', () => choose('rejected'));
    closeButton?.addEventListener('click', () => { if (notice) notice.hidden = true; });
    window.addEventListener('storage', (event) => { if (event.key === cookieName || event.key === null) synchronize(); });
    window.addEventListener('pageshow', synchronize);
    window.addEventListener('focus', synchronize);
    window.setInterval(synchronize, 30000);
    if (readChoice() === null) showNotice();
    synchronize();
})();
