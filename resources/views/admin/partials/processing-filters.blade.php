<form method="GET" class="toolbar processing-filters">
    <label class="field"><span>Статус</span><select name="status">
        <option value="">Все статусы</option>
        @foreach ($statusLabels as $value => $label)
            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
        @endforeach
    </select></label>
    <label class="field"><span>Ответственный</span><select name="assignee_id">
        <option value="">Все сотрудники</option>
        @foreach ($managers as $manager)
            <option value="{{ $manager->id }}" @selected((string) request('assignee_id') === (string) $manager->id)>{{ $manager->name }}</option>
        @endforeach
    </select></label>
    <label class="checkbox processing-filters__mine"><input type="checkbox" name="mine" value="1" @checked(request()->boolean('mine'))> Только мои</label>
    <button type="submit" class="button button--secondary button--inline">Показать</button>
    <a class="button button--secondary button--inline" href="{{ $indexUrl }}">Сбросить</a>
</form>
