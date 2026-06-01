<?php

declare(strict_types=1);

namespace Leadora\Agents\Support;

/**
 * PHP encodes empty arrays as JSON arrays ([]). API dict fields need {}.
 */
final class JsonObject
{
    /**
     * @param array<string, mixed> $map
     */
    public static function map(array $map): \stdClass|array
    {
        return $map === [] ? new \stdClass() : $map;
    }
}
