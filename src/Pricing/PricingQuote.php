<?php

declare(strict_types=1);

namespace Leadora\Agents\Pricing;

final class PricingQuote
{
    /**
     * @param list<PricingFilterLine> $appliedFilters
     * @param list<array<string, mixed>> $queryPredicates
     */
    public function __construct(
        public readonly array $appliedFilters,
        public readonly string $multiplierProduct,
        public readonly string $basePricePerNumber,
        public readonly string $unitPriceBeforeTax,
        public readonly string $taxRatePercent,
        public readonly string $taxAmountPerUnit,
        public readonly string $unitPriceAfterTax,
        public readonly ?int $matchCount,
        public readonly bool $matchCountIsExact,
        public readonly ?string $countMode,
        public readonly ?string $totalBeforeTax,
        public readonly ?string $totalTax,
        public readonly ?string $totalAfterTax,
        public readonly array $queryPredicates,
        public readonly string $message,
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
                $applied[] = PricingFilterLine::fromArray($row);
            }
        }

        return new self(
            appliedFilters: $applied,
            multiplierProduct: (string) $data['multiplier_product'],
            basePricePerNumber: (string) $data['base_price_per_number'],
            unitPriceBeforeTax: (string) $data['unit_price_before_tax'],
            taxRatePercent: (string) $data['tax_rate_percent'],
            taxAmountPerUnit: (string) $data['tax_amount_per_unit'],
            unitPriceAfterTax: (string) $data['unit_price_after_tax'],
            matchCount: isset($data['match_count']) ? (int) $data['match_count'] : null,
            matchCountIsExact: (bool) ($data['match_count_is_exact'] ?? true),
            countMode: isset($data['count_mode']) ? (string) $data['count_mode'] : null,
            totalBeforeTax: isset($data['total_before_tax']) ? (string) $data['total_before_tax'] : null,
            totalTax: isset($data['total_tax']) ? (string) $data['total_tax'] : null,
            totalAfterTax: isset($data['total_after_tax']) ? (string) $data['total_after_tax'] : null,
            queryPredicates: is_array($data['query_predicates'] ?? null) ? $data['query_predicates'] : [],
            message: (string) ($data['message'] ?? ''),
        );
    }
}
