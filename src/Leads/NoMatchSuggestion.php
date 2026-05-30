<?php

declare(strict_types=1);

namespace Leadora\Agents\Leads;

use Leadora\Agents\Filters\LeadStructuredFilters;

final class NoMatchSuggestion
{
    public function __construct(
        public readonly string $messageFa,
        public readonly LeadStructuredFilters $relaxedFilters,
        public readonly int $matchCount,
        public readonly string $naturalLanguageForRetry,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            messageFa: (string) $data['message_fa'],
            relaxedFilters: LeadStructuredFilters::fromArray(
                is_array($data['relaxed_filters'] ?? null) ? $data['relaxed_filters'] : [],
            ),
            matchCount: (int) $data['match_count'],
            naturalLanguageForRetry: (string) $data['natural_language_for_retry'],
        );
    }
}
