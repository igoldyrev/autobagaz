<section class="admin-card processing-panel" aria-label="Обработка">
    <div class="processing-summary">
        <span class="status processing-status processing-status--{{ $rental->status }}">{{ $rental->statusLabel() }}</span>
        <span>Ответственный: <strong>{{ $rental->assignee?->name ?? 'Не назначен' }}</strong></span>
        @if($rental->isOverdue())<strong class="response-state--late">Просрочен возврат оборудования</strong>@endif
    </div>
    <div class="processing-response">
        @include('admin.partials.response-status', ['responseRecord' => $rental, 'compact' => false])
    </div>
    <ol class="processing-steps" aria-label="Этапы обработки">
        @foreach(App\Models\RentalRequest::statusLabels() as $value => $label)
            @continue($value === 'cancelled' || ($value === 'purchased' && $rental->status !== 'purchased') || ($rental->status === 'purchased' && in_array($value, ['returned', 'completed'], true)))
            <li @if($rental->status === $value) aria-current="step" @endif>{{ $label }}</li>
        @endforeach
    </ol>
    @if(in_array($rental->status, ['new', 'in_progress'], true) && !$rental->deposit_type)
        <p>Перед подтверждением заполните <a class="text-link" href="#rental-terms">условия проката и залога</a> и нажмите «Сохранить условия».</p>
    @endif
    <div class="form-actions processing-actions">
        @foreach($rental->availableActions() as $action => $label)
            @if($action === 'confirm' && !$rental->deposit_type)
                <a class="button button--primary button--inline" href="#rental-terms">Заполнить условия и залог</a>
            @elseif(in_array($action, ['start', 'confirm', 'revise', 'complete'], true))
                @include('admin.rental-requests._form-start', ['formClass' => ''])
                    <button class="button button--primary button--inline" type="submit">{{ $label }}</button>
                </form>
            @else
                <details class="{{ $action === 'cancel' ? 'processing-cancellation' : 'rental-processing-action' }}" @if($errors->any() && old('action') === $action) open @endif>
                    <summary class="{{ $action === 'cancel' ? 'text-link' : 'button button--primary button--inline' }}">{{ $label }}</summary>
                    @include('admin.rental-requests._form-start')
                        @if($action === 'purchase')
                            @php
                                $balance = $rental->deposit_type === 'money' ? $rental->depositBalance() : 0;
                                $price = App\Models\RentalRequest::cents($rental->buyout_price);
                            @endphp
                            <p class="field--wide">Цена выкупа: {{ $rental->buyout_price }} ₽. Зачёт залога: {{ number_format(min($balance, $price) / 100, 2, ',', ' ') }} ₽. Вернуть из залога: {{ number_format(max(0, $balance - $price) / 100, 2, ',', ' ') }} ₽.@if($rental->deposit_type === 'document') Необходимо вернуть документ клиенту.@endif</p>
                            <label class="field"><span>Полученная доплата за выкуп, ₽</span><input name="buyout_paid" type="number" min="0" max="1000000000" step="0.01" value="{{ old('action') === $action ? old('buyout_paid', number_format(max(0, $price - $balance) / 100, 2, '.', '')) : number_format(max(0, $price - $balance) / 100, 2, '.', '') }}" required></label>
                        @endif
                        <label class="field field--wide"><span>{{ $action === 'cancel' ? 'Причина отмены · только для сотрудников' : 'Комментарий' }}</span><textarea name="note" rows="2" maxlength="2000" @required($action === 'cancel')>{{ old('action') === $action ? old('note') : '' }}</textarea></label>
                        @if(in_array($action, ['issue', 'return_equipment', 'purchase'], true))
                            <label class="checkbox field--wide"><input type="checkbox" name="confirmed" value="1" required> {{ $action === 'purchase' ? 'Подтверждаю выкуп, получение доплаты и возврат излишка залога или документа клиенту' : 'Подтверждаю фактическую передачу всего оборудования' }}</label>
                        @endif
                        <div class="form-actions field--wide"><button class="button {{ $action === 'cancel' ? 'button--danger' : 'button--primary' }} button--inline" type="submit">{{ $label }}</button></div>
                    </form>
                </details>
            @endif
        @endforeach
    </div>
    @unless($rental->isClosed())
        <details class="processing-assignee-picker" @if($errors->has('assignee_id')) open @endif>
            <summary class="text-link">Изменить ответственного</summary>
            @include('admin.rental-requests._form-start', ['action' => 'assign', 'formClass' => 'processing-assignee'])
                <label class="field"><span>Назначить ответственного</span><select name="assignee_id" required>
                    <option value="">Выберите сотрудника</option>
                    @foreach($managers as $manager)<option value="{{ $manager->id }}" @selected($rental->assignee_id === $manager->id)>{{ $manager->name }}</option>@endforeach
                </select></label>
                <button type="submit" class="button button--secondary">Назначить</button>
            </form>
        </details>
    @endunless
    <form method="POST" action="{{ route('admin.rental-requests.update', $rental) }}" class="processing-comment">
        @csrf @method('PUT')
        <input type="hidden" name="version" value="{{ $rental->version }}">
        <label class="field"><span>Внутренний комментарий</span><textarea name="note" rows="3" maxlength="2000" required placeholder="Итоги разговора, договорённости или заметка для коллег">{{ in_array(old('action'), ['comment', 'contact', 'contact_failed'], true) ? old('note') : '' }}</textarea></label>
        <p class="admin-content__lead">Виден только сотрудникам. Для первого ответа опишите результат и нажмите «Связался с покупателем». Попытка без ответа срок не останавливает.</p>
        <div class="form-actions processing-actions">
            <button type="submit" name="action" value="comment" class="button button--secondary button--inline">Добавить комментарий</button>
            @if(!$rental->isClosed() && !$rental->first_response_at)
                <button type="submit" name="action" value="contact" class="button button--primary button--inline">Связался с покупателем</button>
                <button type="submit" name="action" value="contact_failed" class="button button--secondary button--inline">Не удалось связаться</button>
            @endif
        </div>
    </form>
</section>
