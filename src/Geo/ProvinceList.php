<?php

declare(strict_types=1);

namespace Leadora\Agents\Geo;

final class ProvinceList
{
    /**
     * @param list<Province> $items
     */
    public function __construct(
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
                $items[] = Province::fromArray($row);
            }
        }

        return new self(
            items: $items,
            total: (int) ($data['total'] ?? count($items)),
        );
    }
}
