<?php

declare(strict_types=1);

namespace Leadora\Agents\Users;

final class UserList
{
    /**
     * @param list<UserListItem> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $limit,
        public readonly int $offset,
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
                $items[] = UserListItem::fromArray($row);
            }
        }

        return new self(
            items: $items,
            total: (int) ($data['total'] ?? 0),
            limit: (int) ($data['limit'] ?? 0),
            offset: (int) ($data['offset'] ?? 0),
        );
    }
}
