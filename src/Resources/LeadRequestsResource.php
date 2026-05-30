<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Http\Transport;
use Leadora\Agents\LeadRequests\LeadRequestCreate;
use Leadora\Agents\LeadRequests\LeadRequestCreateResult;
use Leadora\Agents\LeadRequests\LeadRequestPayResult;

final class LeadRequestsResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function create(LeadRequestCreate $request): LeadRequestCreateResult
    {
        $data = $this->transport->request(
            'POST',
            'v1/lead-requests',
            $request->toArray(),
            headers: $this->headers,
        );

        return LeadRequestCreateResult::fromArray($data);
    }

    public function pay(string $publicId): LeadRequestPayResult
    {
        $data = $this->transport->request(
            'POST',
            'v1/lead-requests/'.rawurlencode($publicId).'/pay',
            headers: $this->headers,
        );

        return LeadRequestPayResult::fromArray($data);
    }
}
