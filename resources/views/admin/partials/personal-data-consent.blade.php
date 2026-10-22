<section class="admin-card order-details">
    <h2>Согласие на обработку данных</h2>
    @if ($record->consent_accepted_at)
        <p>Подтверждено {{ $record->consent_accepted_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s') }}. Версия: {{ $record->consent_version }}.</p>
        <details><summary>Текст подтверждённого согласия</summary><p style="white-space: pre-line">{{ $record->consent_text }}</p></details>
    @else
        <p>Подтверждение согласия в этой записи не зафиксировано.</p>
    @endif
</section>
