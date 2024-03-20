<?php

namespace App;

class CountryCode
{
    const ALPHA2_CODES = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU',
            'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
    public static function isEu(string $alpha2): bool
    {
        return in_array($alpha2, self::ALPHA2_CODES);
    }
}