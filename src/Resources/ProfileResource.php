<?php

declare(strict_types=1);

namespace Leadora\Agents\Resources;

use Leadora\Agents\Http\Transport;
use Leadora\Agents\Profile\AgentProfile;

final class ProfileResource
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly Transport $transport,
        private readonly array $headers,
    ) {
    }

    public function get(): AgentProfile
    {
        $data = $this->transport->request('GET', 'v1/profile', headers: $this->headers);

        return AgentProfile::fromArray($data);
    }
}
