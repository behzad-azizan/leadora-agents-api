<?php

declare(strict_types=1);

namespace Leadora\Agents\Operators;

final class OperatorList
{
    /**
     * @param list<Operator> $items
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
                $items[] = Operator::fromArray($row);
            }
        }

        return new self(
            items: $items,
            total: (int) ($data['total'] ?? count($items)),
        );
    }
}
