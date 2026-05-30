<?php

declare(strict_types=1);

namespace Leadora\Agents\Operators;

final class Operator
{
    public function __construct(
        public readonly string $code,
        public readonly string $nameFa,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: (string) $data['code'],
            nameFa: (string) $data['name_fa'],
        );
    }
}
