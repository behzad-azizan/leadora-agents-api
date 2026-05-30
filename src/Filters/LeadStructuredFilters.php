<?php

declare(strict_types=1);

namespace Leadora\Agents\Filters;

final class LeadStructuredFilters
{
    /**
     * @param list<int> $provinceIds
     * @param list<int> $cityIds
     * @param list<string> $provinces
     * @param list<string> $cities
     * @param list<int> $municipalDistrictNos
     * @param list<string> $genders
     * @param list<string> $operators
     * @param list<int> $ageBuckets
     * @param list<int> $sourceIds
     * @param list<int> $batchIds
     * @param list<string> $mobilePrefixes
     * @param list<AgeRange> $ageRanges
     */
    public function __construct(
        public readonly array $provinceIds = [],
        public readonly array $cityIds = [],
        public readonly array $provinces = [],
        public readonly array $cities = [],
        public readonly array $municipalDistrictNos = [],
        public readonly array $genders = [],
        public readonly array $operators = [],
        public readonly array $ageBuckets = [],
        public readonly array $sourceIds = [],
        public readonly array $batchIds = [],
        public readonly array $mobilePrefixes = [],
        public readonly array $ageRanges = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $ageRanges = [];
        foreach ($data['age_ranges'] ?? [] as $row) {
            if (is_array($row)) {
                $ageRanges[] = AgeRange::fromArray($row);
            }
        }

        return new self(
            provinceIds: array_values(array_map('intval', $data['province_ids'] ?? [])),
            cityIds: array_values(array_map('intval', $data['city_ids'] ?? [])),
            provinces: array_values(array_map('strval', $data['provinces'] ?? [])),
            cities: array_values(array_map('strval', $data['cities'] ?? [])),
            municipalDistrictNos: array_values(array_map('intval', $data['municipal_district_nos'] ?? [])),
            genders: array_values(array_map('strval', $data['genders'] ?? [])),
            operators: array_values(array_map('strval', $data['operators'] ?? [])),
            ageBuckets: array_values(array_map('intval', $data['age_buckets'] ?? [])),
            sourceIds: array_values(array_map('intval', $data['source_ids'] ?? [])),
            batchIds: array_values(array_map('intval', $data['batch_ids'] ?? [])),
            mobilePrefixes: array_values(array_map('strval', $data['mobile_prefixes'] ?? [])),
            ageRanges: $ageRanges,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'province_ids' => $this->provinceIds,
            'city_ids' => $this->cityIds,
            'provinces' => $this->provinces,
            'cities' => $this->cities,
            'municipal_district_nos' => $this->municipalDistrictNos,
            'genders' => $this->genders,
            'operators' => $this->operators,
            'age_buckets' => $this->ageBuckets,
            'source_ids' => $this->sourceIds,
            'batch_ids' => $this->batchIds,
            'mobile_prefixes' => $this->mobilePrefixes,
            'age_ranges' => array_map(static fn (AgeRange $r) => $r->toArray(), $this->ageRanges),
        ];
    }

    public function isEmpty(): bool
    {
        return $this->provinceIds === []
            && $this->cityIds === []
            && $this->provinces === []
            && $this->cities === []
            && $this->municipalDistrictNos === []
            && $this->genders === []
            && $this->operators === []
            && $this->ageBuckets === []
            && $this->sourceIds === []
            && $this->batchIds === []
            && $this->mobilePrefixes === []
            && $this->ageRanges === [];
    }
}
