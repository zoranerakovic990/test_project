<?php

namespace App;

use InvalidArgumentException;

class InputReader
{
    public static function process(array $argv)
    {
        if (!isset($argv[1])) {
            throw new InvalidArgumentException('Please pass a name of file as an argument!');
        }

        $lines = explode("\n", file_get_contents($argv[1]));
        $output = '';

        foreach ($lines as $row) {
            if (empty($row)) {
                break;
            }

            $data = json_decode($row);

            $binInfo = Transaction::fetchBinInfo($data);
            $isEu = CountryCode::isEu($binInfo->country->alpha2);

            // exchageratesapi stopped working so this code does not change
            $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$data->currency];
            $amntFixed = Transaction::calculateFixedAmount($data, $rate);

            $output .= round($amntFixed * ($isEu ? 0.01 : 0.02), 2) . "\n";
        }

        return $output;
    }
}