<?php

declare(strict_types=1);

namespace Leadora\Agents\Tests\Exception;

use Leadora\Agents\Exception\ApiException;
use PHPUnit\Framework\TestCase;

final class ApiExceptionTest extends TestCase
{
    public function test_parses_fastapi_validation_detail(): void
    {
        $e = ApiException::fromResponse(422, [
            'detail' => [
                [
                    'loc' => ['body', 'mobile'],
                    'msg' => 'Field required',
                    'type' => 'missing',
                ],
            ],
        ]);

        self::assertSame('validation.error', $e->errorCode);
        self::assertSame('body.mobile: Field required', $e->getMessage());
        self::assertSame(422, $e->statusCode);
    }
}
