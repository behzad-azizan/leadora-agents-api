<?php

declare(strict_types=1);

namespace Leadora\Agents\Profile;

final class AgentProfile
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly int $walletBalance,
        public readonly int $usersCount,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            username: (string) $data['username'],
            status: (string) $data['status'],
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
            walletBalance: (int) $data['wallet_balance'],
            usersCount: (int) $data['users_count'],
        );
    }
}
