<?php

declare(strict_types=1);

namespace Leadora\Agents\Agent;

final class AgentInfo
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $status,
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
        );
    }
}
