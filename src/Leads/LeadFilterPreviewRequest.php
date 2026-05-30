<?php

declare(strict_types=1);

namespace Leadora\Agents\Leads;

use Leadora\Agents\Filters\LeadStructuredFilters;

final class LeadFilterPreviewRequest
{
    public readonly LeadStructuredFilters $filters;

    public function __construct(
        ?LeadStructuredFilters $filters = null,
        public readonly ?string $naturalLanguageIntent = null,
        public readonly ?string $campaignMessage = null,
        public readonly ?string $countMode = null,
        public readonly bool $allowUnbounded = false,
    ) {
        $this->filters = $filters ?? new LeadStructuredFilters();

        $hasNl = $this->naturalLanguageIntent !== null && trim($this->naturalLanguageIntent) !== '';
        $hasCamp = $this->campaignMessage !== null && trim($this->campaignMessage) !== '';

        if ($hasNl && $hasCamp) {
            throw new \InvalidArgumentException(
                'Only one of naturalLanguageIntent or campaignMessage may be set.'
            );
        }

        if (($hasNl || $hasCamp) && ! $this->filters->isEmpty()) {
            throw new \InvalidArgumentException(
                'Structured filters must be empty when using natural language or campaign message.'
            );
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [
            'filters' => $this->filters->toArray(),
            'allow_unbounded' => $this->allowUnbounded,
        ];

        if ($this->naturalLanguageIntent !== null) {
            $payload['natural_language_intent'] = $this->naturalLanguageIntent;
        }

        if ($this->campaignMessage !== null) {
            $payload['campaign_message'] = $this->campaignMessage;
        }

        if ($this->countMode !== null) {
            $payload['count_mode'] = $this->countMode;
        }

        return $payload;
    }
}
