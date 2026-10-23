<section class="admin-card processing-panel" aria-label="Обработка">
    <div class="processing-summary">
        <span class="status processing-status processing-status--{{ $record->status }}">{{ $record->statusLabel() }}</span>
        <span>Ответственный: <strong>{{ $record->assignee?->name ?? 'Не назначен' }}</strong></span>
    </div>
    @if ($record instanceof \App\Models\Order)<p>{{ $record->statusDescription() }}</p>@endif
    <ol class="processing-steps" aria-label="Этапы обработки">
        @foreach (($record instanceof \App\Models\Order ? $record->processingSteps() : $record::statusLabels()) as $value => $label)
            @continue($value === 'cancelled')
            <li @if($record->status === $value) aria-current="step" @endif>{{ $label }}</li>
        @endforeach
    </ol>
    <div class="form-actions processing-actions">
        @foreach ($record->availableActions() as $value => $label)
            <form method="POST" action="{{ $updateUrl }}" @if($value === 'cancelled') onsubmit="return confirm('Подтвердить отмену?')" @endif>
                @csrf @method('PUT')
                <input type="hidden" name="expected_status" value="{{ $record->status }}">
                @if ($record instanceof \App\Models\Order)
                    <input type="hidden" name="expected_terms_version" value="{{ $record->latestTermsVersion?->version ?? 0 }}">
                    @if ($value === \App\Models\Order::STATUS_COMPLETED)
                        <input type="hidden" name="fulfillment_confirmed" value="1">
                    @endif
                @endif
                <button type="submit" name="status" value="{{ $value }}" class="button {{ $value === 'cancelled' ? 'button--danger' : 'button--primary button--inline' }}">{{ $record instanceof \App\Models\Order && $value === \App\Models\Order::STATUS_COMPLETED ? 'Заказ получен / установка завершена' : $label }}</button>
            </form>
        @endforeach
        @if ($record->isClosed() && auth()->user()->canReopenOrders())
            <form method="POST" action="{{ $updateUrl }}" onsubmit="return confirm('Вернуть запись в работу?')">
                @csrf @method('PUT')
                <input type="hidden" name="expected_status" value="{{ $record->status }}">
                <button type="submit" name="status" value="in_progress" class="button button--secondary">Вернуть в работу</button>
            </form>
        @endif
    </div>
    @error('status')<p class="field__error">{{ $message }}</p>@enderror
    @error('expected_terms_version')<p class="field__error">{{ $message }}</p>@enderror
    @error('fulfillment_confirmed')<p class="field__error">{{ $message }}</p>@enderror
    @if ($record instanceof \App\Models\Order && ! $record->isClosed() && $record->latestTermsVersion && ! $record->latestTermsVersion->accepted_at)
        <p>Менеджер предложил изменения. Для продолжения покупатель должен подтвердить их по ссылке на заказ.</p>
    @endif
    @error('expected_status')<p class="field__error">{{ $message }}</p>@enderror
    @unless ($assigneeExpanded ?? false)
    <details class="processing-assignee-picker" @if($errors->has('assignee_id')) open @endif>
        <summary class="text-link">Изменить ответственного</summary>
    @endunless
        <form method="POST" action="{{ $updateUrl }}" class="processing-assignee">
            @csrf @method('PUT')
            <label class="field"><span>Назначить ответственного</span><select name="assignee_id" required>
                <option value="">Выберите сотрудника</option>
                @foreach ($managers as $manager)
                    <option value="{{ $manager->id }}" @selected($record->assignee_id === $manager->id)>{{ $manager->name }}</option>
                @endforeach
            </select></label>
            <button type="submit" class="button button--secondary">Назначить</button>
        </form>
    @unless ($assigneeExpanded ?? false)
    </details>
    @endunless
    @error('assignee_id')<p class="field__error">{{ $message }}</p>@enderror
</section>
