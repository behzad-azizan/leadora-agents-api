<?php

declare(strict_types=1);

namespace Leadora\Agents\Exception;

final class ApiException extends LeadoraException
{
    /**
     * @param array<string, mixed> $details
     */
    public function __construct(
        public readonly string $errorCode,
        string $message,
        public readonly int $statusCode,
        public readonly array $details = [],
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * @param array<string, mixed> $body
     */
    public static function fromResponse(int $statusCode, array $body): self
    {
        $error = $body['error'] ?? [];
        if (! is_array($error)) {
            $error = [];
        }

        return new self(
            errorCode: (string) ($error['code'] ?? 'unknown'),
            message: (string) ($error['message'] ?? 'Request failed'),
            statusCode: $statusCode,
            details: is_array($error['details'] ?? null) ? $error['details'] : [],
        );
    }
}
