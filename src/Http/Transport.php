<?php

declare(strict_types=1);

namespace Leadora\Agents\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Leadora\Agents\Config;
use Leadora\Agents\Exception\ApiException;
use Leadora\Agents\Exception\TransportException;
use Leadora\Agents\Support\ApiHeaders;
use Psr\Http\Message\ResponseInterface;

final class Transport
{
    private readonly ClientInterface $http;

    public function __construct(
        private readonly Config $config,
        ?ClientInterface $http = null,
    ) {
        $this->http = $http ?? new GuzzleClient([
            'base_uri' => $this->config->baseUrl.'/',
            'timeout' => $this->config->timeout,
            'http_errors' => false,
        ]);
    }

    /**
     * @param array<string, mixed>|null $json
     * @param array<string, string> $headers
     * @param array<string, int|string> $query
     * @return array<string, mixed>
     */
    public function request(
        string $method,
        string $path,
        ?array $json = null,
        array $headers = [],
        array $query = [],
    ): array {
        $options = [
            'headers' => $this->mergeHeaders($headers),
        ];

        if ($query !== []) {
            $options['query'] = $query;
        }

        if ($json !== null) {
            $options['body'] = json_encode($json, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        }

        try {
            $response = $this->http->request($method, ltrim($path, '/'), $options);
        } catch (GuzzleException $e) {
            throw new TransportException($e->getMessage(), 0, $e);
        } catch (\JsonException $e) {
            throw new TransportException('Failed to encode request body as JSON', 0, $e);
        }

        return $this->decode($response);
    }

    /**
     * @param array<string, string> $extra
     * @return array<string, string>
     */
    private function mergeHeaders(array $extra): array
    {
        return array_merge(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                ApiHeaders::API_TOKEN => $this->config->apiToken,
            ],
            $extra,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function decode(ResponseInterface $response): array
    {
        $status = $response->getStatusCode();
        $raw = (string) $response->getBody();

        if ($raw === '') {
            $payload = [];
        } else {
            try {
                $payload = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new TransportException(
                    'Invalid JSON in API response (HTTP '.$status.')',
                    0,
                    $e,
                );
            }

            if (! is_array($payload)) {
                throw new TransportException('Expected JSON object in API response');
            }
        }

        if ($status >= 400) {
            throw ApiException::fromResponse($status, $payload);
        }

        return $payload;
    }
}
