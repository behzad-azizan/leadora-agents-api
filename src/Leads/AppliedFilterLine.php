<?php

declare(strict_types=1);

namespace Leadora\Agents\Leads;

final class AppliedFilterLine
{
    public function __construct(
        public readonly string $field,
        public readonly string $op,
        public readonly mixed $value,
        public readonly string $labelFa,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            field: (string) $data['field'],
            op: (string) $data['op'],
            value: $data['value'] ?? null,
            labelFa: (string) ($data['label_fa'] ?? ''),
        );
    }
}
