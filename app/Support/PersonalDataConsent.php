<?php

namespace App\Support;

class PersonalDataConsent
{
    public const VERSION = '2026-10-22-2';

    public static function view(): string
    {
        return 'legal.consent-'.self::VERSION;
    }

    public static function attributes(): array
    {
        return [
            'consent_accepted_at' => now(),
            'consent_version' => self::VERSION,
            'consent_text' => trim(html_entity_decode(strip_tags(view(self::view())->render()), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
        ];
    }
}
