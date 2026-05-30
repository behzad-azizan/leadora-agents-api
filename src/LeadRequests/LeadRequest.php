<?php

declare(strict_types=1);

namespace Leadora\Agents\LeadRequests;

use Leadora\Agents\Filters\LeadStructuredFilters;

final class LeadRequest
{
    public function __construct(
        public readonly int $id,
        public readonly string $publicId,
        public readonly int $agentId,
        public readonly int $userId,
        public readonly LeadStructuredFilters $filters,
        public readonly int $requestedQuantity,
        public readonly int $matchCount,
        public readonly string $countMode,
        public readonly string $unitPriceBeforeTax,
        public readonly string $unitPriceAfterTax,
        public readonly string $taxRatePercent,
        public readonly string $quotedTotalBeforeTax,
        public readonly string $quotedTotalTax,
        public readonly string $quotedTotalAfterTax,
        public readonly bool $isPaid,
        public readonly ?string $paidAt,
        public readonly ?string $paidAmount,
        public readonly bool $isDelivered,
        public readonly ?string $deliveredAt,
        public readonly ?int $ledgerEntryId,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            publicId: (string) $data['public_id'],
            agentId: (int) $data['agent_id'],
            userId: (int) $data['user_id'],
            filters: LeadStructuredFilters::fromArray(
                is_array($data['filters'] ?? null) ? $data['filters'] : [],
            ),
            requestedQuantity: (int) $data['requested_quantity'],
            matchCount: (int) $data['match_count'],
            countMode: (string) $data['count_mode'],
            unitPriceBeforeTax: (string) $data['unit_price_before_tax'],
            unitPriceAfterTax: (string) $data['unit_price_after_tax'],
            taxRatePercent: (string) $data['tax_rate_percent'],
            quotedTotalBeforeTax: (string) $data['quoted_total_before_tax'],
            quotedTotalTax: (string) $data['quoted_total_tax'],
            quotedTotalAfterTax: (string) $data['quoted_total_after_tax'],
            isPaid: (bool) $data['is_paid'],
            paidAt: isset($data['paid_at']) ? (string) $data['paid_at'] : null,
            paidAmount: isset($data['paid_amount']) ? (string) $data['paid_amount'] : null,
            isDelivered: (bool) $data['is_delivered'],
            deliveredAt: isset($data['delivered_at']) ? (string) $data['delivered_at'] : null,
            ledgerEntryId: isset($data['ledger_entry_id']) ? (int) $data['ledger_entry_id'] : null,
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
        );
    }
}
