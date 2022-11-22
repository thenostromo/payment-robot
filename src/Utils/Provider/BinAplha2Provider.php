<?php

namespace App\Utils\Provider;

class BinAplha2Provider
{
    public const BIN_ALPHA2_ZONE_SK = 'SK';

    /**
     * @param string $alpha2
     * @return bool
     */
    public static function isEuroZone(string $alpha2): bool
    {
        return self::BIN_ALPHA2_ZONE_SK === $alpha2;
    }
}
