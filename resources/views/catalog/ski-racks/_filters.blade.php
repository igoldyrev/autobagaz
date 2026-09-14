<form class="catalog-filters {{ ($horizontal ?? false) ? 'catalog-filters--horizontal' : '' }}" method="get" action="{{ url()->current() }}">
    <div class="catalog-filters__header">
        <h2>Фильтры товаров</h2>
        @if (request()->query())
            <a href="{{ url()->current() }}">Сбросить</a>
        @endif
    </div>
@if($filterOptions['manufacturers']->isNotEmpty())<fieldset class="catalog-filter"><legend>Производитель</legend>@foreach($filterOptions['manufacturers'] as $m)<label><input type="checkbox" name="manufacturer[]" value="{{$m->id}}" @checked(in_array((string)$m->id,$filters['manufacturers'],true))> {{$m->name}}</label>@endforeach</fieldset>@endif
<fieldset class="catalog-filter catalog-filter--price"><legend>Цена, ₽</legend><label><span>от</span><input name="price_from" type="number" value="{{$filters['price_from']}}"></label><label><span>до</span><input name="price_to" type="number" value="{{$filters['price_to']}}"></label></fieldset>
<fieldset class="catalog-filter"><legend>Товар</legend><label><input type="checkbox" name="availability[]" value="in_stock" @checked(in_array('in_stock',$filters['availability'],true))> В наличии</label><label><input type="checkbox" name="availability[]" value="to_order" @checked(in_array('to_order',$filters['availability'],true))> Под заказ</label></fieldset>
@if($filterOptions['ski_pairs']->isNotEmpty())<fieldset class="catalog-filter"><legend>Вместимость, пар лыж</legend>@foreach($filterOptions['ski_pairs'] as $value)<label><input type="checkbox" name="ski_pairs[]" value="{{$value}}" @checked(in_array((string)$value,$filters['ski_pairs'],true))> {{$value}}</label>@endforeach</fieldset>@endif
@if($filterOptions['snowboards']->isNotEmpty())<fieldset class="catalog-filter"><legend>Вместимость, сноубордов</legend>@foreach($filterOptions['snowboards'] as $value)<label><input type="checkbox" name="snowboard[]" value="{{$value}}" @checked(in_array((string)$value,$filters['snowboards'],true))> {{$value}}</label>@endforeach</fieldset>@endif
    <button class="catalog-filters__submit" type="submit">Показать</button>
</form>
