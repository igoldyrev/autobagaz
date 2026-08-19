<?php

namespace Tests\Unit;

use App\Services\VehicleBodyTypeDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VehicleBodyTypeDetectorTest extends TestCase
{
    #[DataProvider('bodyTypeProvider')]
    public function test_it_extracts_a_normalized_body_type(string $sourceName, ?string $expected): void
    {
        $this->assertSame($expected, (new VehicleBodyTypeDetector)->detect($sourceName));
    }

    public static function bodyTypeProvider(): array
    {
        return [
            ['Vesta Седан с 2015-нв', 'Седан'],
            ['Vesta Универсал 2017-нв (интегрированные рейлинги)', 'Универсал'],
            ['A3 5дв. Хэтчбек', 'Хэтчбек'],
            ['Octavia Лифтбек 2013-2020', 'Лифтбек'],
            ['Mustang Coupe', 'Купе'],
            ['Grand Cherokee 5дв. Джип 2007-нв', 'Внедорожник'],
            ['Transporter Фургон', 'Фургон'],
            ['Camry 2018-нв (гладкая крыша)', null],
        ];
    }

    public function test_it_extracts_every_body_type_from_a_combined_source_category(): void
    {
        $this->assertSame(
            ['Седан', 'Универсал'],
            (new VehicleBodyTypeDetector)->detectAll('Audi 80/90 седан/универсал 4/5дв.'),
        );
    }
}
