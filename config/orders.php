<?php

return [
    // Comma-separated addresses; the legacy single address remains supported.
    'notification_emails' => env('ORDER_NOTIFICATION_EMAILS'),
    'notification_email' => env('ORDER_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS')),
];
