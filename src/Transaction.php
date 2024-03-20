<?php

namespace App;

use Exception;

class Transaction
{
    public static function fetchBinInfo($data)
    {
        self::validate($data);

        $binInfo = file_get_contents('https://lookup.binlist.net/' . $data->bin);
        if (!$binInfo) {
            throw new Exception("Error occured while getting a BIN result!");
        }
        $binInfo = json_decode($binInfo);

        // check country code exists
        if (!(isset($binInfo->country) && isset($binInfo->country->alpha2))) {
            throw new Exception("Country Alpha2 Code does not exists!");
        }

        return $binInfo;
    }

    public static function calculateFixedAmount($data, $rate)
    {
        if ($data->currency == 'EUR' || $rate == 0) {
            $amntFixed = $data->amount;
        }
        if ($data->currency != 'EUR' || $rate > 0) {
            $amntFixed = $data->amount / $rate;
        }

        return $amntFixed;
    }

    private static function validate($data)
    {
        if (!isset($data->bin)) {
            throw new Exception("BIN is missing!");
        }
        if (!isset($data->amount)) {
            throw new Exception("Amount is missing!");
        }
        if (!isset($data->currency)) {
            throw new Exception("Currency is missing!");
        }
    }
}