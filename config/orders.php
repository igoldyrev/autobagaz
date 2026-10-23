<?php

return [
    'default_assignee_id' => env('ORDER_DEFAULT_ASSIGNEE_ID'),
    'default_assignee_name' => 'Максим',
    // Comma-separated addresses; the legacy single address remains supported.
    'notification_emails' => env('ORDER_NOTIFICATION_EMAILS'),
    'notification_email' => env('ORDER_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS')),
];
