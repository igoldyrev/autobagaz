<div class="crossbar-requirements">
    <p>Проверьте параметры ваших поперечин. Совместимость с ними пока не подтверждена.</p>
    @php($box = $accessory->autoBox)
    @if ($box)
        <ul>
            @if ($box->clamp_width_min_mm !== null || $box->clamp_width_max_mm !== null)
                <li>Ширина профиля: @if ($box->clamp_width_min_mm !== null)от {{ $box->clamp_width_min_mm }}@endif @if ($box->clamp_width_max_mm !== null)до {{ $box->clamp_width_max_mm }}@endif мм.</li>
            @endif
            @if ($box->clamp_height_max_mm !== null)
                <li>Высота профиля: до {{ $box->clamp_height_max_mm }} мм.</li>
            @endif
            @if ($box->crossbar_spacing_min_mm !== null || $box->crossbar_spacing_max_mm !== null)
                <li>Расстояние между поперечинами: @if ($box->crossbar_spacing_min_mm !== null)от {{ $box->crossbar_spacing_min_mm }}@endif @if ($box->crossbar_spacing_max_mm !== null)до {{ $box->crossbar_spacing_max_mm }}@endif мм.</li>
            @endif
            @if ($box->required_t_slot_width_mm !== null)
                <li>Ширина T-паза: не менее {{ $box->required_t_slot_width_mm }} мм.</li>
            @endif
            @if (filled($box->mounting_type))
                <li>Тип крепления: {{ $box->mounting_type }}.</li>
            @endif
        </ul>
    @endif
    <p>Сверьте ширину и высоту профиля, расстояние между поперечинами, крепления и допустимую нагрузку с инструкцией производителя товара и багажника. Если параметры не указаны, уточните их у менеджера до покупки.</p>
</div>
