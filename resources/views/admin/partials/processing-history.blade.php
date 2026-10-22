<section class="admin-card processing-history">
    <h2>История изменений</h2>
    <p class="admin-content__lead">Журнал хранится 180 дней.</p>
    <ul>
        @forelse ($history as $entry)
            <li><time datetime="{{ $entry->created_at->toIso8601String() }}">{{ $entry->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</time> · <strong>{{ $entry->user_name }}</strong><p>{{ $entry->description }}</p></li>
        @empty
            <li>Изменений пока нет.</li>
        @endforelse
    </ul>
    @include('admin.partials.pagination', ['paginator' => $history])
</section>
