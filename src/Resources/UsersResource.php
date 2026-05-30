<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Http\Transport;
use Leadora\Agents\Support\ApiHeaders;
use Leadora\Agents\Users\RegisterUserRequest;
use Leadora\Agents\Users\UpdateUserRequest;
use Leadora\Agents\Users\UserDetail;
use Leadora\Agents\Users\UserList;
use Leadora\Agents\Users\UserRegistration;

final class UsersResource
{
    /**
     * @param array<string, string> $defaultHeaders
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $defaultHeaders = [],
    ) {
    }

    /**
     * Register a sub-user in Leadora (idempotent on `agent_unique_id`).
     *
     * Only `X-API-Token` is sent — call this right after signup on the agent site.
     */
    public function register(RegisterUserRequest $request): UserRegistration
    {
        $data = $this->transport->request(
            'POST',
            'v1/users',
            $request->toArray(),
        );

        return UserRegistration::fromArray($data);
    }

    public function list(int $limit = 50, int $offset = 0): UserList
    {
        $data = $this->transport->request(
            'GET',
            'v1/users',
            query: [
                'limit' => $limit,
                'offset' => $offset,
            ],
        );

        return UserList::fromArray($data);
    }

    public function get(int $userId): UserDetail
    {
        $data = $this->transport->request(
            'GET',
            "v1/users/{$userId}",
            headers: $this->userContextHeaders($userId),
        );

        return UserDetail::fromArray($data);
    }

    public function update(int $userId, UpdateUserRequest $request): UserDetail
    {
        $data = $this->transport->request(
            'PATCH',
            "v1/users/{$userId}",
            $request->toArray(),
            headers: $this->userContextHeaders($userId),
        );

        return UserDetail::fromArray($data);
    }

    /**
     * @return array<string, string>
     */
    private function userContextHeaders(int $userId): array
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException('userId must be a positive integer');
        }

        return array_merge($this->defaultHeaders, [
            ApiHeaders::USER_ID => (string) $userId,
        ]);
    }
}
