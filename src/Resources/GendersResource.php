<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Genders\GenderList;
use Leadora\Agents\Http\Transport;

final class GendersResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function list(): GenderList
    {
        $data = $this->transport->request('GET', 'v1/genders', headers: $this->headers);

        return GenderList::fromArray($data);
    }
}
