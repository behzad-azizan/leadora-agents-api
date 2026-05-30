<?php

declare(strict_types=1);

namespace Leadora\Agents\Users;

final class UpdateUserRequest
{
    /**
     * @param array<string, mixed>|null $extraFields
     */
    public function __construct(
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $mobile = null,
        public readonly ?string $status = null,
        public readonly ?array $extraFields = null,
    ) {
        if ($this->status !== null && ! in_array($this->status, ['active', 'inactive', 'blocked'], true)) {
            throw new \InvalidArgumentException('status must be active, inactive, or blocked');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if ($this->firstName !== null) {
            $payload['first_name'] = $this->firstName;
        }

        if ($this->lastName !== null) {
            $payload['last_name'] = $this->lastName;
        }

        if ($this->mobile !== null) {
            $payload['mobile'] = $this->mobile;
        }

        if ($this->status !== null) {
            $payload['status'] = $this->status;
        }

        if ($this->extraFields !== null) {
            $payload['extra_fields'] = $this->extraFields;
        }

        if ($payload === []) {
            throw new \InvalidArgumentException('At least one field must be set for update');
        }

        return $payload;
    }
}
