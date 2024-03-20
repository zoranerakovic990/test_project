<?php

namespace tests;

use App\InputReader;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class InputReaderTest extends TestCase
{
    public function testMissingArguments()
    {
        $this->expectException(InvalidArgumentException::class);
        InputReader::process([]);
    }

    public function testEmptyRow()
    {
        $args = ['src/app.php', 'input.txt'];
        InputReader::process($args);
    }
}
