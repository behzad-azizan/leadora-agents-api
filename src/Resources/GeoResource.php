<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Geo\CityList;
use Leadora\Agents\Geo\ProvinceList;
use Leadora\Agents\Http\Transport;

final class GeoResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function provinces(): ProvinceList
    {
        $data = $this->transport->request('GET', 'v1/geo/provinces', headers: $this->headers);

        return ProvinceList::fromArray($data);
    }

    public function cities(int $provinceId): CityList
    {
        $data = $this->transport->request(
            'GET',
            'v1/geo/cities',
            headers: $this->headers,
            query: ['province_id' => $provinceId],
        );

        return CityList::fromArray($data);
    }
}
