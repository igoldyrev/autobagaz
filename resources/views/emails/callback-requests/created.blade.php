<h1>Новая заявка на обратный звонок</h1>
<p><strong>Время заявки:</strong> {{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>
<p><a href="{{ route('admin.callback-requests.show', $callbackRequest) }}">Открыть заявку в админке</a></p>
