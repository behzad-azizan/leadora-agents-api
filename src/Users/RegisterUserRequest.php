<?php

declare(strict_types=1);

namespace Leadora\Agents\Users;

final class RegisterUserRequest
{
    /**
     * @param array<string, mixed> $extraFields
     */
    public function __construct(
        public readonly string $mobile,
        public readonly string $agentUniqueId,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly array $extraFields = [],
    ) {
        if ($this->mobile === '') {
            throw new \InvalidArgumentException('mobile is required');
        }

        if ($this->agentUniqueId === '') {
            throw new \InvalidArgumentException('agentUniqueId is required');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [
            'mobile' => $this->mobile,
            'agent_unique_id' => $this->agentUniqueId,
            'extra_fields' => $this->extraFields,
        ];

        if ($this->firstName !== null) {
            $payload['first_name'] = $this->firstName;
        }

        if ($this->lastName !== null) {
            $payload['last_name'] = $this->lastName;
        }

        return $payload;
    }
}
