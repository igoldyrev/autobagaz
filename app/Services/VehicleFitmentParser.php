<?php

namespace App\Services;

class VehicleFitmentParser
{
    /** @var array<string, array<string>> */
    private const MOUNTING_PATTERNS = [
        'Интегрированные рейлинги' => ['интегр', 'integr', 'int_reyling'],
        'Штатные места' => ['штатные места', 'штатное место', 'shtatnie_mesta', 'shtatnoe_mesto'],
        'Т-профиль' => ['т-профиль', 'т профиль', 't_profil'],
        'Гладкая крыша' => ['гладкая крыша', 'гладкую крышу', 'gladkaya_krisha', 'gladkuyu_krishu'],
        'Водостоки' => ['водосток', 'vodostok'],
        'За дверной проём' => ['дверной проём', 'дверной проем', 'за двери', 'dvernoy_proem', 'dvernoj_proem'],
        'Рейлинги' => ['рейлинг', 'reyling'],
    ];

    public function years(string $label, string $sourceSlug): ?string
    {
        $values = [];
        $normalizedLabel = mb_strtolower(str_replace(['‑', '–', '—'], '-', $label));

        preg_match_all(
            '/(?<!\d)((?:19|20)\d{2})\s*(?:г(?:г|\.)?)?\s*-\s*((?:19|20)\d{2}|н\.?\s*в\.?)\s*(?:г(?:г|\.)?)?(?!\d)/u',
            $normalizedLabel,
            $ranges,
            PREG_SET_ORDER,
        );

        foreach ($ranges as $range) {
            $values[] = $range[1].'–'.($this->isCurrent($range[2]) ? 'н.в.' : $range[2]);
        }

        preg_match_all(
            '/(?<!\d)((?:19|20)\d{2})\s*(?:г\.?\s*)?(?:и\s*)?по\s*н\.?\s*в\.?/u',
            $normalizedLabel,
            $currentRanges,
            PREG_SET_ORDER,
        );

        foreach ($currentRanges as $range) {
            $values[] = $range[1].'–н.в.';
        }

        preg_match_all(
            '/(?<!\d)((?:19|20)\d{2})\s*(?:г\.?\s*)?[^\d]{0,45}(?:и\s*)?по\s*(?:н\.?\s*в\.?|наст\.?\s*время)/u',
            $normalizedLabel,
            $longCurrentRanges,
            PREG_SET_ORDER,
        );

        foreach ($longCurrentRanges as $range) {
            $values[] = $range[1].'–н.в.';
        }

        preg_match_all(
            '/(?:^|[^\p{L}\d])(?:с|c)?\s*((?:19|20)\d{2})\s*(?:г\.?)?\s*-\s*(?!\d)/u',
            $normalizedLabel,
            $openRanges,
            PREG_SET_ORDER,
        );

        foreach ($openRanges as $range) {
            $values[] = $range[1].'–н.в.';
        }

        preg_match_all('/(?:^|[^\p{L}\d])(?:с|c)\s*((?:19|20)\d{2})(?!\d)/u', $normalizedLabel, $fromRanges, PREG_SET_ORDER);

        foreach ($fromRanges as $range) {
            $values[] = $range[1].'–н.в.';
        }

        preg_match_all('/\bдо\s*((?:19|20)\d{2})\s*г?\.?/u', $normalizedLabel, $beforeRanges, PREG_SET_ORDER);

        foreach ($beforeRanges as $range) {
            $values[] = 'до '.$range[1];
        }

        if ($values === [] && preg_match('/(?<!\d)((?:19|20)\d{2})\s*г\.(?!\d)/u', $normalizedLabel, $singleYear)) {
            $values[] = $singleYear[1];
        }

        if ($values === []) {
            $slug = mb_strtolower(str_replace('-', '_', $sourceSlug));
            preg_match_all('/(?<!\d)((?:19|20)\d{2})_(?:g_)?((?:19|20)\d{2})(?:gg|g)?(?!\d)/', $slug, $slugRanges, PREG_SET_ORDER);

            foreach ($slugRanges as $range) {
                $values[] = $range[1].'–'.$range[2];
            }

            preg_match_all('/(?<!\d)((?:19|20)\d{2})(?:g)?_(?:i_)?po_nv(?![a-z])/', $slug, $slugCurrent, PREG_SET_ORDER);

            foreach ($slugCurrent as $range) {
                $values[] = $range[1].'–н.в.';
            }

            if ($values === [] && preg_match('/(?<!\d)((?:19|20)\d{2})g(?:_|$)/', $slug, $slugYear)) {
                $values[] = $slugYear[1];
            }
        }

        $values = array_values(array_unique($values));

        return $values === [] ? null : implode(' / ', $values);
    }

    public function mountingType(string $label, string $sourceSlug): ?string
    {
        $haystack = mb_strtolower($label.' '.str_replace('-', '_', $sourceSlug));

        foreach (self::MOUNTING_PATTERNS as $mountingType => $patterns) {
            foreach ($patterns as $pattern) {
                if (str_contains($haystack, $pattern)) {
                    return $mountingType;
                }
            }
        }

        return null;
    }

    private function isCurrent(string $value): bool
    {
        return str_contains(preg_replace('/[\s.]+/u', '', mb_strtolower($value)), 'нв');
    }
}
