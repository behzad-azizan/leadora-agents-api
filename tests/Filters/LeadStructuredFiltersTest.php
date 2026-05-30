<?php

declare(strict_types=1);

namespace Leadora\Agents\Tests\Filters;

use Leadora\Agents\Filters\AgeRange;
use Leadora\Agents\Filters\LeadStructuredFilters;
use PHPUnit\Framework\TestCase;

final class LeadStructuredFiltersTest extends TestCase
{
    public function test_round_trip_to_api_shape(): void
    {
        $filters = new LeadStructuredFilters(
            provinceIds: [8],
            genders: ['male'],
            operators: ['irancell'],
            ageRanges: [new AgeRange(25, 40)],
        );

        self::assertSame([
            'province_ids' => [8],
            'city_ids' => [],
            'provinces' => [],
            'cities' => [],
            'municipal_district_nos' => [],
            'genders' => ['male'],
            'operators' => ['irancell'],
            'age_buckets' => [],
            'source_ids' => [],
            'batch_ids' => [],
            'mobile_prefixes' => [],
            'age_ranges' => [['min_age' => 25, 'max_age' => 40]],
        ], $filters->toArray());

        $restored = LeadStructuredFilters::fromArray($filters->toArray());
        self::assertFalse($restored->isEmpty());
        self::assertSame([8], $restored->provinceIds);
    }
}
