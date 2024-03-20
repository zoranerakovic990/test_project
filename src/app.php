<?php

namespace App;

require_once 'vendor/autoload.php';

use Exception;


try {
    InputReader::process($argv = []);
} catch (Exception $e) {
    echo $e->getMessage();
}
