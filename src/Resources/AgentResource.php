<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Agent\AgentInfo;
use Leadora\Agents\Http\Transport;

final class AgentResource
{
    public function __construct(
        private readonly Transport $transport,
    ) {
    }

    public function me(): AgentInfo
    {
        $data = $this->transport->request('GET', 'me');

        return AgentInfo::fromArray($data);
    }
}
