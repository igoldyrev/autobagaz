<?php

namespace Tests\Unit;

use App\Services\VehicleFitmentParser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VehicleFitmentParserTest extends TestCase
{
    #[DataProvider('yearProvider')]
    public function test_it_extracts_years(string $label, string $slug, ?string $expected): void
    {
        $this->assertSame($expected, (new VehicleFitmentParser)->years($label, $slug));
    }

    public static function yearProvider(): array
    {
        return [
            ['Vesta Седан с 2015-нв', 'sedan_s_2015g_po_nv', '2015–н.в.'],
            ['A4 Седан 1998-2004', 'sedan_1998_2004gg', '1998–2004'],
            ['Audi 80 Седан/Универсал 1987-1994/1992-1995', 'combined', '1987–1994 / 1992–1995'],
            ['Peugeot 2008', 'bagazhniki_dlya_peugeot_2008', null],
            ['H5 2023-', '2023-int-reylingi', '2023–н.в.'],
            ['7-serie G11/G12 2015 по наст.время', 'g11-2015', '2015–н.в.'],
            ['Ducato Bus до 1995г.', 'bus-do-1995g', 'до 1995'],
            ['C4 Grand Picasso 5 дв. 2014 г.', 'grand-picasso-2014g', '2014'],
            ['C4 Grand Picasso 5 дв. 2014', 'grand-picasso-2014g', '2014'],
            ['Jetta VII c 2018', 'jetta-vii-c-2018', '2018–н.в.'],
        ];
    }

    #[DataProvider('mountingProvider')]
    public function test_it_extracts_mounting_type(string $label, string $slug, ?string $expected): void
    {
        $this->assertSame($expected, (new VehicleFitmentParser)->mountingType($label, $slug));
    }

    public static function mountingProvider(): array
    {
        return [
            ['Vesta Универсал (интегрированные рейлинги)', 'integr_reylingi', 'Интегрированные рейлинги'],
            ['Galaxy (интегрир. рейлинги)', 'integrir-reylingi', 'Интегрированные рейлинги'],
            ['A4 Седан (штатные места)', 'shtatnie_mesta', 'Штатные места'],
            ['Largus на рейлинги', 'reylingi', 'Рейлинги'],
            ['Niva на водостоки', 'vodostoki', 'Водостоки'],
            ['Camry гладкая крыша', 'gladkaya_krisha', 'Гладкая крыша'],
            ['Модель без уточнения', 'model', null],
        ];
    }
}
