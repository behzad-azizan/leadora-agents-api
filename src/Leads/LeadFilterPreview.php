<?php

declare(strict_types=1);

namespace Leadora\Agents\Leads;

use Leadora\Agents\Filters\LeadStructuredFilters;

final class LeadFilterPreview
{
    /**
     * @param list<AppliedFilterLine> $appliedFilters
     */
    public function __construct(
        public readonly array $appliedFilters,
        public readonly string $message,
        public readonly int $matchCount,
        public readonly bool $matchCountIsExact,
        public readonly string $countMode,
        public readonly LeadStructuredFilters $resolvedStructuredFilters,
        public readonly ?NoMatchSuggestion $noMatchSuggestion,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $applied = [];
        foreach ($data['applied_filters'] ?? [] as $row) {
            if (is_array($row)) {
                $applied[] = AppliedFilterLine::fromArray($row);
            }
        }

        $suggestion = null;
        if (is_array($data['no_match_suggestion'] ?? null)) {
            $suggestion = NoMatchSuggestion::fromArray($data['no_match_suggestion']);
        }

        return new self(
            appliedFilters: $applied,
            message: (string) ($data['message'] ?? ''),
            matchCount: (int) $data['match_count'],
            matchCountIsExact: (bool) ($data['match_count_is_exact'] ?? true),
            countMode: (string) $data['count_mode'],
            resolvedStructuredFilters: LeadStructuredFilters::fromArray(
                is_array($data['resolved_structured_filters'] ?? null)
                    ? $data['resolved_structured_filters']
                    : [],
            ),
            noMatchSuggestion: $suggestion,
        );
    }
}
