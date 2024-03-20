<?php

namespace tests;

use App\CountryCode;
use PHPUnit\Framework\TestCase;

class CountryCodeTest extends TestCase
{
    public function testIsEuWithValidCountryCode()
    {
        $this->assertTrue(CountryCode::isEu('DE'));
    }

    public function testIsEuWithInvalidCountryCode()
    {
        $this->assertFalse(CountryCode::isEu('US'));
    }
}