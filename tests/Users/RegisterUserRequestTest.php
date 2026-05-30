<?php

declare(strict_types=1);

namespace Leadora\Agents\Tests\Users;

use Leadora\Agents\Users\RegisterUserRequest;
use PHPUnit\Framework\TestCase;

final class RegisterUserRequestTest extends TestCase
{
    public function test_to_array_snake_case_for_api(): void
    {
        $request = new RegisterUserRequest(
            mobile: '09121234567',
            agentUniqueId: '42',
            firstName: 'Ali',
            lastName: 'Rezaei',
            extraFields: ['plan' => 'basic'],
        );

        self::assertSame([
            'mobile' => '09121234567',
            'agent_unique_id' => '42',
            'extra_fields' => ['plan' => 'basic'],
            'first_name' => 'Ali',
            'last_name' => 'Rezaei',
        ], $request->toArray());
    }
}
