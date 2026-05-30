<?php

declare(strict_types=1);

namespace Leadora\Agents\Geo;

final class City
{
    public function __construct(
        public readonly int $id,
        public readonly string $nameFa,
        public readonly int $provinceId,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            nameFa: (string) $data['name_fa'],
            provinceId: (int) $data['province_id'],
        );
    }
}
