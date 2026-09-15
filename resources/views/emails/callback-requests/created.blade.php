<h1>Новая заявка на обратный звонок</h1>
<p><strong>Имя:</strong> {{ $callbackRequest->name }}</p>
<p><strong>Телефон:</strong> <a href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a></p>
<p><strong>Время заявки:</strong> {{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>
