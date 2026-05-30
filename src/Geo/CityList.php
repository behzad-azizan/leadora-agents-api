<?php

declare(strict_types=1);

namespace Leadora\Agents\Geo;

final class CityList
{
    /**
     * @param list<City> $items
     */
    public function __construct(
        public readonly int $provinceId,
        public readonly array $items,
        public readonly int $total,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $items = [];
        foreach ($data['items'] ?? [] as $row) {
            if (is_array($row)) {
                $items[] = City::fromArray($row);
            }
        }

        return new self(
            provinceId: (int) $data['province_id'],
            items: $items,
            total: (int) ($data['total'] ?? count($items)),
        );
    }
}
