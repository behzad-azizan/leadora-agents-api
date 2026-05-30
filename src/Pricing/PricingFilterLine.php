<?php

declare(strict_types=1);

namespace Leadora\Agents\Pricing;

final class PricingFilterLine
{
    public function __construct(
        public readonly string $filterKey,
        public readonly string $labelFa,
        public readonly string $multiplier,
        public readonly string $description,
        public readonly string $queryPredicateSummary,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            filterKey: (string) $data['filter_key'],
            labelFa: (string) $data['label_fa'],
            multiplier: (string) $data['multiplier'],
            description: (string) $data['description'],
            queryPredicateSummary: (string) $data['query_predicate_summary'],
        );
    }
}
