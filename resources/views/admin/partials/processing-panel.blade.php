<section class="admin-card processing-panel" aria-label="Обработка">
    <div class="processing-summary">
        <span class="status processing-status processing-status--{{ $record->status }}">{{ $record->statusLabel() }}</span>
        <span>Ответственный: <strong>{{ $record->assignee?->name ?? 'Не назначен' }}</strong></span>
    </div>
    <ol class="processing-steps" aria-label="Этапы обработки">
        @foreach ($record::statusLabels() as $value => $label)
            @continue($value === 'cancelled')
            <li @if($record->status === $value) aria-current="step" @endif>{{ $label }}</li>
        @endforeach
    </ol>
    <div class="form-actions processing-actions">
        @foreach ($record->availableActions() as $value => $label)
            <form method="POST" action="{{ $updateUrl }}" @if($value === 'cancelled') onsubmit="return confirm('Подтвердить отмену?')" @endif>
                @csrf @method('PUT')
                <input type="hidden" name="expected_status" value="{{ $record->status }}">
                <button type="submit" name="status" value="{{ $value }}" class="button {{ $value === 'cancelled' ? 'button--danger' : 'button--primary button--inline' }}">{{ $label }}</button>
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
    @error('expected_status')<p class="field__error">{{ $message }}</p>@enderror
    <details class="processing-assignee-picker" @if($errors->has('assignee_id')) open @endif>
        <summary class="text-link">Изменить ответственного</summary>
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
    </details>
    @error('assignee_id')<p class="field__error">{{ $message }}</p>@enderror
</section>
