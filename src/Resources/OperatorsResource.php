<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Http\Transport;
use Leadora\Agents\Operators\OperatorList;

final class OperatorsResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function list(): OperatorList
    {
        $data = $this->transport->request('GET', 'v1/operators', headers: $this->headers);

        return OperatorList::fromArray($data);
    }
}
