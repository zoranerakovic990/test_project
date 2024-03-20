<?php

namespace tests;

use App\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testInvalidBin()
    {
        $this->expectExceptionMessage('BIN is missing!');

        Transaction::fetchBinInfo(new class {
            public $amount;
            public $currency;

            public function __construct()
            {
                $this->amount = 123;
                $this->currency = 'EUR';
            }
        });
    }

    public function testInvalidAmount()
    {
        $this->expectExceptionMessage('Amount is missing!');

        Transaction::fetchBinInfo(new class {
            public $bin;
            public $currency;

            public function __construct()
            {
                $this->bin = 12554347;
                $this->currency = 'EUR';
            }
        });
    }

    public function testInvalidCurrency()
    {
        $this->expectExceptionMessage('Currency is missing!');

        Transaction::fetchBinInfo(new class {
            public $bin;
            public $amount;

            public function __construct()
            {
                $this->bin = 12554347;
                $this->amount = 22;
            }
        });
    }

    public function testCalculateEurFixedAmount()
    {
        $amount = Transaction::calculateFixedAmount($data = new class {
            public $bin;
            public $amount;
            public $currency;

            public function __construct()
            {
                $this->bin = 12554347;
                $this->amount = 22;
                $this->currency = 'EUR';
            }
        }, 0);
        $this->assertIsNumeric($amount);
        $this->assertThat($data->amount, $this->equalTo($amount));
    }


    public function testCalculateUsdFixedAmount()
    {
        $rate = 0.92;
        $amount = Transaction::calculateFixedAmount($data = new class {
            public $bin;
            public $amount;
            public $currency;

            public function __construct()
            {
                $this->bin = 12554347;
                $this->amount = 22.60;
                $this->currency = 'USD';
            }
        }, $rate);
        $this->assertIsNumeric($amount);
        $this->assertThat($data->amount / $rate, $this->equalTo($amount));
    }
}
