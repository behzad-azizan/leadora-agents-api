<?php

declare(strict_types=1);

namespace Leadora\Agents\Filters;

final class AgeRange
{
    public function __construct(
        public readonly int $minAge,
        public readonly int $maxAge,
    ) {
        if ($this->minAge > $this->maxAge) {
            throw new \InvalidArgumentException('minAge cannot be greater than maxAge');
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            minAge: (int) ($data['min_age'] ?? $data['minAge'] ?? 0),
            maxAge: (int) ($data['max_age'] ?? $data['maxAge'] ?? 0),
        );
    }

    /**
     * @return array<string, int>
     */
    public function toArray(): array
    {
        return [
            'min_age' => $this->minAge,
            'max_age' => $this->maxAge,
        ];
    }
}
