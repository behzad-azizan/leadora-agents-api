<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Http\Transport;
use Leadora\Agents\Pricing\PricingQuote;
use Leadora\Agents\Pricing\PricingQuoteRequest;

final class PricingResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function quote(PricingQuoteRequest $request): PricingQuote
    {
        $data = $this->transport->request(
            'POST',
            'v1/pricing/quote',
            $request->toArray(),
            headers: $this->headers,
        );

        return PricingQuote::fromArray($data);
    }
}
