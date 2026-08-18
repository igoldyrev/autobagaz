@if ($paginator->hasPages())
    <nav class="catalog-pagination" aria-label="Навигация по страницам товаров">
        @if ($paginator->onFirstPage())
            <span class="catalog-pagination__item catalog-pagination__item--disabled" aria-disabled="true">←</span>
        @else
            <a class="catalog-pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Предыдущая страница">←</a>
        @endif

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page === $paginator->currentPage())
                <span class="catalog-pagination__item catalog-pagination__item--current" aria-current="page">{{ $page }}</span>
            @else
                <a class="catalog-pagination__item" href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="catalog-pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Следующая страница">→</a>
        @else
            <span class="catalog-pagination__item catalog-pagination__item--disabled" aria-disabled="true">→</span>
        @endif
    </nav>
@endif
