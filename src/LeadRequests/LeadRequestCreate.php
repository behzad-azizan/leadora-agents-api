<?php

declare(strict_types=1);

namespace Leadora\Agents\LeadRequests;

use Leadora\Agents\Filters\LeadStructuredFilters;

final class LeadRequestCreate
{
    public function __construct(
        public readonly LeadStructuredFilters $filters,
        public readonly int $requestedQuantity,
        public readonly ?string $countMode = null,
    ) {
        if ($this->requestedQuantity <= 0) {
            throw new \InvalidArgumentException('requestedQuantity must be greater than zero');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [
            'filters' => $this->filters->toArray(),
            'requested_quantity' => $this->requestedQuantity,
        ];

        if ($this->countMode !== null) {
            $payload['count_mode'] = $this->countMode;
        }

        return $payload;
    }
}
