<?php

declare(strict_types=1);

namespace Leadora\Agents\Pricing;

use Leadora\Agents\Filters\LeadStructuredFilters;

final class PricingQuoteRequest
{
    public readonly LeadStructuredFilters $filters;

    public function __construct(
        public readonly ?int $provinceId = null,
        public readonly ?int $cityId = null,
        public readonly ?int $municipalDistrictNo = null,
        public readonly ?string $gender = null,
        public readonly ?int $ageMin = null,
        public readonly ?int $ageMax = null,
        public readonly ?string $operator = null,
        public readonly ?string $mobilePrefix = null,
        public readonly bool $withCount = false,
        public readonly ?string $countMode = null,
        ?LeadStructuredFilters $filters = null,
    ) {
        $this->filters = $filters ?? new LeadStructuredFilters();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [
            'with_count' => $this->withCount,
            'filters' => $this->filters->toArray(),
        ];

        if ($this->provinceId !== null) {
            $payload['province_id'] = $this->provinceId;
        }

        if ($this->cityId !== null) {
            $payload['city_id'] = $this->cityId;
        }

        if ($this->municipalDistrictNo !== null) {
            $payload['municipal_district_no'] = $this->municipalDistrictNo;
        }

        if ($this->gender !== null) {
            $payload['gender'] = $this->gender;
        }

        if ($this->ageMin !== null) {
            $payload['age_min'] = $this->ageMin;
        }

        if ($this->ageMax !== null) {
            $payload['age_max'] = $this->ageMax;
        }

        if ($this->operator !== null) {
            $payload['operator'] = $this->operator;
        }

        if ($this->mobilePrefix !== null) {
            $payload['mobile_prefix'] = $this->mobilePrefix;
        }

        if ($this->countMode !== null) {
            $payload['count_mode'] = $this->countMode;
        }

        return $payload;
    }
}
