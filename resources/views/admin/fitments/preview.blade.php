@extends('layouts.admin')
@section('title', 'Предпросмотр '.$fitment->code)
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--wide">@include('admin.partials.flash')
<nav class="admin-breadcrumbs"><a href="{{ route('admin.fitments.index') }}">Группы применяемости</a><span>/</span><a href="{{ route('admin.fitments.edit', $fitment) }}">{{ $fitment->code }}</a><span>/</span><span>Предпросмотр</span></nav>
<div class="page-heading"><div><p class="eyebrow">Предпросмотр применяемости</p><h1>{{ $fitment->name }}</h1><p class="admin-content__lead">{{ $fitment->configurations->count() }} конфигураций × {{ $fitment->products->count() }} товаров = {{ $fitment->configurations->count() * $fitment->products->count() }} потенциальных прямых соответствий.</p></div><a class="button button--secondary button--inline" href="{{ route('admin.fitments.configurations', $fitment) }}">Настроить автомобили</a></div>
<section><h2>Товары</h2>@forelse($fitment->products as $product)<p><strong>{{ $product->name }}</strong> · {{ $product->roofRack?->manufacturer?->name ?? 'производитель не указан' }}</p>@empty<p class="empty-state">Товары не добавлены.</p>@endforelse</section>
<section><h2>Совместимые автомобили</h2>@forelse($groups as $makeName => $models)<h3>{{ $makeName }}</h3>@foreach($models as $modelName => $configurations)<div class="table-wrap"><table class="admin-table fitment-preview-table"><thead><tr><th>{{ $modelName }}</th><th>Кузов</th><th>Крыша</th></tr></thead><tbody>@foreach($configurations as $configuration)<tr><td>{{ $configuration->generation->display_name }} · {{ $configuration->display_name }}</td><td>{{ $configuration->bodyStyle?->name ?? '—' }}</td><td>{{ $configuration->roofType?->name ?? '—' }}</td></tr>@endforeach</tbody></table></div>@endforeach @empty<p class="empty-state">Автомобили не добавлены.</p>@endforelse</section>
</main></div>
@endsection
