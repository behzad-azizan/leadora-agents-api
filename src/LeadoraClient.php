<?php

declare(strict_types=1);

namespace Leadora\Agents;

use GuzzleHttp\ClientInterface;
use Leadora\Agents\Http\Transport;
use Leadora\Agents\Resources\AgentResource;
use Leadora\Agents\Resources\GendersResource;
use Leadora\Agents\Resources\GeoResource;
use Leadora\Agents\Resources\LeadRequestsResource;
use Leadora\Agents\Resources\LeadsResource;
use Leadora\Agents\Resources\OperatorsResource;
use Leadora\Agents\Resources\PricingResource;
use Leadora\Agents\Resources\ProfileResource;
use Leadora\Agents\Resources\UsersResource;
use Leadora\Agents\Support\ApiHeaders;

final class LeadoraClient
{
    private readonly Transport $transport;

    public function __construct(
        private readonly Config $config,
        ?ClientInterface $http = null,
        private readonly ?int $userId = null,
    ) {
        $this->transport = new Transport($this->config, $http);
    }

    public static function create(string $baseUrl, string $apiToken, ?ClientInterface $http = null): self
    {
        return new self(new Config($baseUrl, $apiToken), $http);
    }

    /**
     * Scope subsequent calls to a Leadora sub-user (`users.id` → `X-User-Id`).
     */
    public function forUser(int $userId): self
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException('userId must be a positive integer');
        }

        return new self($this->config, null, $userId);
    }

    public function users(): UsersResource
    {
        return new UsersResource($this->transport, $this->userHeaders());
    }

    public function agent(): AgentResource
    {
        return new AgentResource($this->transport);
    }

    public function profile(): ProfileResource
    {
        return new ProfileResource($this->transport, $this->requireUserHeaders());
    }

    public function geo(): GeoResource
    {
        return new GeoResource($this->transport, $this->requireUserHeaders());
    }

    public function operators(): OperatorsResource
    {
        return new OperatorsResource($this->transport, $this->requireUserHeaders());
    }

    public function genders(): GendersResource
    {
        return new GendersResource($this->transport, $this->requireUserHeaders());
    }

    public function leads(): LeadsResource
    {
        return new LeadsResource($this->transport, $this->requireUserHeaders());
    }

    public function pricing(): PricingResource
    {
        return new PricingResource($this->transport, $this->requireUserHeaders());
    }

    public function leadRequests(): LeadRequestsResource
    {
        return new LeadRequestsResource($this->transport, $this->requireUserHeaders());
    }

    public function userId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return array<string, string>
     */
    private function userHeaders(): array
    {
        if ($this->userId === null) {
            return [];
        }

        return [ApiHeaders::USER_ID => (string) $this->userId];
    }

    /**
     * @return array<string, string>
     */
    private function requireUserHeaders(): array
    {
        if ($this->userId === null) {
            throw new \LogicException(
                'This endpoint requires a sub-user context. Call forUser($leadoraUserId) first.'
            );
        }

        return $this->userHeaders();
    }
}
