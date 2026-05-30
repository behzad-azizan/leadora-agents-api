<?php

declare(strict_types=1);

namespace Leadora\Agents\Users;

final class UserDetail
{
    /**
     * @param array<string, mixed> $extraFields
     */
    public function __construct(
        public readonly int $id,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly string $mobile,
        public readonly string $status,
        public readonly int $agentId,
        public readonly string $agentUniqueId,
        public readonly array $extraFields,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            firstName: isset($data['first_name']) ? (string) $data['first_name'] : null,
            lastName: isset($data['last_name']) ? (string) $data['last_name'] : null,
            mobile: (string) $data['mobile'],
            status: (string) $data['status'],
            agentId: (int) $data['agent_id'],
            agentUniqueId: (string) $data['agent_unique_id'],
            extraFields: is_array($data['extra_fields'] ?? null) ? $data['extra_fields'] : [],
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
        );
    }
}
