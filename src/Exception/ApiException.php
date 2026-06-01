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
        $error = $body['error'] ?? null;
        if (is_array($error)) {
            return new self(
                errorCode: (string) ($error['code'] ?? 'unknown'),
                message: (string) ($error['message'] ?? 'Request failed'),
                statusCode: $statusCode,
                details: is_array($error['details'] ?? null) ? $error['details'] : [],
            );
        }

        if (array_key_exists('detail', $body)) {
            return new self(
                errorCode: $statusCode === 422 ? 'validation.error' : 'api.error',
                message: self::formatDetail($body['detail']),
                statusCode: $statusCode,
                details: ['detail' => $body['detail']],
            );
        }

        return new self(
            errorCode: 'unknown',
            message: 'Request failed',
            statusCode: $statusCode,
            details: $body,
        );
    }

    private static function formatDetail(mixed $detail): string
    {
        if (is_string($detail)) {
            return $detail;
        }

        if (! is_array($detail)) {
            return 'Validation failed';
        }

        $lines = [];
        foreach ($detail as $item) {
            if (! is_array($item)) {
                continue;
            }

            $loc = implode('.', array_map('strval', $item['loc'] ?? []));
            $msg = (string) ($item['msg'] ?? '');
            $line = $loc !== '' ? $loc.': '.$msg : $msg;
            if ($line !== '') {
                $lines[] = $line;
            }
        }

        return $lines !== [] ? implode('; ', $lines) : 'Validation failed';
    }
}
