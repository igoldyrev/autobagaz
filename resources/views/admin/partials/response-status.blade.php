@if ($responseRecord->first_response_at)
    <span class="response-state {{ $responseRecord->responseWasLate() ? 'response-state--late' : '' }}">Первый контакт состоялся{{ $responseRecord->responseWasLate() ? ' · с опозданием' : '' }}</span>
    @unless ($compact)
        <p>{{ $responseRecord->first_response_at->timezone(config('orders.response_time.timezone'))->format('d.m.Y H:i') }} · {{ $responseRecord->first_response_by_name }}.</p>
    @endunless
@elseif ($responseRecord->response_due_at === null)
    <span class="response-state">Срок ответа не установлен для старой заявки</span>
@elseif ($responseRecord->isClosed())
    <span class="response-state {{ $responseRecord->responseWasLate() ? 'response-state--late' : '' }}">Закрыт без первого ответа{{ $responseRecord->responseWasLate() ? ' · срок был нарушен' : '' }}</span>
@elseif ($responseRecord->responseWasLate())
    @php($responseDelay = $responseRecord->responseDelayMinutes())
    <span class="response-state response-state--late">Срок ответа истёк@if($responseDelay > 0) · {{ $responseDelay }} раб. мин.@endif</span>
@else
    <span class="response-state">Ответить до {{ $responseRecord->response_due_at->timezone(config('orders.response_time.timezone'))->format('d.m H:i') }}</span>
@endif
@unless ($compact)
    @if ($responseRecord->response_due_at)
        <p>Срок первого ответа: {{ $responseRecord->response_due_at->timezone(config('orders.response_time.timezone'))->format('d.m.Y H:i') }} (GMT+05). Один рабочий час по графику магазина. Контакт можно отметить в любое время.</p>
    @endif
@endunless
