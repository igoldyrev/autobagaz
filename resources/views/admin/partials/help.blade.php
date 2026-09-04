<section class="admin-help" @isset($id) aria-labelledby="{{ $id }}" @endisset>
    <h2 @isset($id) id="{{ $id }}" @endisset>{{ $title }}</h2>
    <p>{{ $text }}</p>
    @if (! empty($items))
        <ul>
            @foreach ($items as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    @endif
</section>
