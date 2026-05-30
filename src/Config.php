<?php

declare(strict_types=1);

namespace Leadora\Agents;

final class Config
{
    public function __construct(
        public readonly string $baseUrl,
        public readonly string $apiToken,
        public readonly float $timeout = 15.0,
    ) {
        if ($this->baseUrl === '') {
            throw new \InvalidArgumentException('baseUrl must not be empty');
        }

        if ($this->apiToken === '') {
            throw new \InvalidArgumentException('apiToken must not be empty');
        }
    }

    public static function fromArray(array $options): self
    {
        return new self(
            baseUrl: rtrim((string) ($options['base_url'] ?? $options['baseUrl'] ?? ''), '/'),
            apiToken: (string) ($options['api_token'] ?? $options['apiToken'] ?? ''),
            timeout: (float) ($options['timeout'] ?? 15.0),
        );
    }
}
