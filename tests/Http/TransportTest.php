<?php

declare(strict_types=1);

namespace Leadora\Agents\Tests\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Leadora\Agents\Config;
use Leadora\Agents\Http\Transport;
use Leadora\Agents\Support\ApiHeaders;
use PHPUnit\Framework\TestCase;

final class TransportTest extends TestCase
{
    public function test_post_sends_json_body_and_headers(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['id' => 1, 'created' => true], JSON_THROW_ON_ERROR)),
        ]);

        $http = new Client([
            'handler' => HandlerStack::create($mock),
            'base_uri' => 'https://api.example/',
        ]);

        $transport = new Transport(
            new Config('https://api.example', 'tok_abc.secret'),
            $http,
        );

        $transport->request('POST', 'v1/users', [
            'mobile' => '09121234567',
            'agent_unique_id' => '42',
            'extra_fields' => [],
        ]);

        $request = $mock->getLastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame('tok_abc.secret', $request->getHeaderLine(ApiHeaders::API_TOKEN));
        self::assertSame(
            '{"mobile":"09121234567","agent_unique_id":"42","extra_fields":[]}',
            (string) $request->getBody(),
        );
    }

    public function test_request_merges_user_id_header(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['ok' => true], JSON_THROW_ON_ERROR)),
        ]);

        $http = new Client([
            'handler' => HandlerStack::create($mock),
            'base_uri' => 'https://api.example/',
        ]);

        $transport = new Transport(
            new Config('https://api.example', 'tok_abc.secret'),
            $http,
        );

        $transport->request(
            'GET',
            'v1/geo/provinces',
            headers: [ApiHeaders::USER_ID => '99'],
        );

        $request = $mock->getLastRequest();
        self::assertSame('99', $request->getHeaderLine(ApiHeaders::USER_ID));
        self::assertSame('tok_abc.secret', $request->getHeaderLine(ApiHeaders::API_TOKEN));
    }
}
