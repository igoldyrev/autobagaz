# Autobagaz Project Snapshot API v1

Контракт описывает read-only снимок состояния проекта «Автобагаж» для внешнего
сборщика данных. Текущая версия схемы — `1.0`, идентификатор источника — `autobagaz`.

## Запрос

```http
GET /internal/monitoring/project-snapshot?date=2026-10-02&limit=3
Authorization: Bearer <DAILY_BRIEF_MONITORING_TOKEN>
Accept: application/json
```

Параметры:

- `date` — необязательная дата отчёта в формате `YYYY-MM-DD`; по умолчанию текущая
  дата в `app.display_timezone`;
- `limit` — необязательное количество последних изменений для каждого
  администратора и общего списка, целое число от 1 до 10; по умолчанию 3.

Ответы не кешируются: `Cache-Control: no-store, private`.

Коды ответа:

- `200` — снимок сформирован;
- `401` — Bearer-токен отсутствует или неверен;
- `422` — параметры запроса не прошли валидацию;
- `503` — `DAILY_BRIEF_MONITORING_TOKEN` не настроен на сервере;
- `429` — превышено ограничение 30 запросов в минуту.

## Схема ответа

Машиночитаемая JSON Schema находится в
[`autobagaz-project-snapshot-v1.schema.json`](autobagaz-project-snapshot-v1.schema.json).

Основные правила:

- время `generated_at` и границы `period` передаются в ISO 8601;
- время входа, присутствия и изменений администраторов нормализовано в UTC;
- денежные суммы передаются строкой с двумя знаками после точки, чтобы не терять
  точность при десериализации;
- `orders.by_status` всегда содержит все пять известных статусов, даже когда их
  значения равны нулю;
- `created_for_day` и `activity` рассчитываются для указанного `period`;
- `callback_requests`, `products` и `vehicle_configurations` отражают состояние на
  момент формирования снимка;
- персональные данные покупателей, состав заказов и исходные комментарии в ответ
  не включаются;
- изменения отображаются только для разрешённых безопасных типов объектов.

Пример сокращённого ответа:

```json
{
  "schema_version": "1.0",
  "source": "autobagaz",
  "state": "ok",
  "generated_at": "2026-10-02T09:15:00+05:00",
  "period": {
    "date": "2026-10-02",
    "timezone": "Asia/Yekaterinburg",
    "starts_at": "2026-10-02T00:00:00+05:00",
    "ends_at": "2026-10-02T23:59:59+05:00"
  },
  "site": {
    "available": true,
    "database": "ok"
  },
  "orders": {
    "by_status": {
      "new": {"label": "Новый", "count": 1, "amount": "12500.00"},
      "in_progress": {"label": "В работе", "count": 0, "amount": "0.00"},
      "confirmed": {"label": "Подтверждён", "count": 0, "amount": "0.00"},
      "completed": {"label": "Завершён", "count": 0, "amount": "0.00"},
      "cancelled": {"label": "Отменён", "count": 0, "amount": "0.00"}
    },
    "created_for_day": {"count": 1, "amount": "12500.00"},
    "awaiting_processing": 1
  },
  "callback_requests": {"new": 0, "unclosed": 0},
  "products": {
    "total": 120,
    "published": 110,
    "hidden": 10,
    "without_images": 2,
    "published_roof_racks_without_fitments": 1
  },
  "vehicle_configurations": {"without_compatibility": 4},
  "administrators": [],
  "activity": {"changes_for_day": 0, "recent_changes": []}
}
```

## Совместимость

В пределах версии `1.x` существующие поля не удаляются и не меняют тип. Новые поля
могут добавляться, поэтому клиент должен игнорировать неизвестные свойства. Удаление,
переименование или изменение типа поля требует новой major-версии контракта и нового
маршрута либо согласованного периода миграции.

Старый маршрут `GET /internal/daily-brief/admin-activity` временно возвращает тот же
ответ для обратной совместимости. Новые клиенты должны использовать
`/internal/monitoring/project-snapshot`.
