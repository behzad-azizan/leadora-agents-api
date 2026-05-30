<?php

declare(strict_types=1);

namespace Leadora\Agents\LeadRequests;

final class LeadRequestCreateResult
{
    public function __construct(
        public readonly LeadRequest $request,
        public readonly string $message,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request: LeadRequest::fromArray(
                is_array($data['request'] ?? null) ? $data['request'] : [],
            ),
            message: (string) ($data['message'] ?? ''),
        );
    }
}
