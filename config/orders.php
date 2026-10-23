<?php

return [
    'response_time' => [
        'timezone' => 'Asia/Yekaterinburg',
        'minutes' => 60,
        'schedule' => [
            ['days' => [1, 2, 3, 4, 5], 'label' => 'Пн–Пт', 'opens' => '10:00', 'closes' => '19:00'],
            ['days' => [6, 7], 'label' => 'Сб–Вс', 'opens' => '10:00', 'closes' => '18:00'],
        ],
    ],
    'default_assignee_id' => env('ORDER_DEFAULT_ASSIGNEE_ID'),
    'default_assignee_name' => 'Максим',
    // Comma-separated addresses; the legacy single address remains supported.
    'notification_emails' => env('ORDER_NOTIFICATION_EMAILS'),
    'notification_email' => env('ORDER_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS')),
];
