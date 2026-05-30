<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Http\Transport;
use Leadora\Agents\Leads\LeadFilterPreview;
use Leadora\Agents\Leads\LeadFilterPreviewRequest;

final class LeadsResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function filterPreview(LeadFilterPreviewRequest $request): LeadFilterPreview
    {
        $data = $this->transport->request(
            'POST',
            'v1/leads/filter-preview',
            $request->toArray(),
            headers: $this->headers,
        );

        return LeadFilterPreview::fromArray($data);
    }
}
