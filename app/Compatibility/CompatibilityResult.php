<?php

namespace App\Compatibility;

use JsonSerializable;

readonly class CompatibilityResult implements JsonSerializable
{
    public const COMPATIBLE = 'compatible';

    public const INCOMPATIBLE = 'incompatible';

    public const UNKNOWN = 'unknown';

    /**
     * @param  array<int, string>  $reasons
     * @param  array<int, string>  $missingData
     */
    public function __construct(
        public string $status,
        public array $reasons = [],
        public array $missingData = [],
        public ?int $matchedBaseProductId = null,
        public ?int $appliedOverrideId = null,
    ) {}

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'reasons' => $this->reasons,
            'missing_data' => $this->missingData,
            'matched_base_product_id' => $this->matchedBaseProductId,
            'applied_override_id' => $this->appliedOverrideId,
        ];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::COMPATIBLE => 'Совместимо',
            self::INCOMPATIBLE => 'Несовместимо',
            self::UNKNOWN => 'Недостаточно данных',
            default => 'Неизвестный результат',
        };
    }

    public function statusExplanation(): string
    {
        return match ($this->status) {
            self::COMPATIBLE => 'Выбранный товар подходит: обязательные условия установки выполнены.',
            self::INCOMPATIBLE => 'Товар не подходит: одно или несколько обязательных условий установки не выполнены.',
            self::UNKNOWN => 'Система не может подтвердить совместимость, пока не заполнены недостающие технические параметры.',
            default => 'Система вернула результат, для которого ещё не задано описание.',
        };
    }
}
