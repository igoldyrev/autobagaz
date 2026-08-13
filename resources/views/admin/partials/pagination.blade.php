@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Навигация по страницам">
        @if ($paginator->onFirstPage())
            <span class="pagination__disabled">← Назад</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">← Назад</a>
        @endif

        <span>Страница {{ $paginator->currentPage() }} из {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Вперёд →</a>
        @else
            <span class="pagination__disabled">Вперёд →</span>
        @endif
    </nav>
@endif
