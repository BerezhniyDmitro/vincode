<?php

require_once __DIR__ . '/vendor/autoload.php';

$vincode = \CheckvinVincode\VinCode::createFromString('1FM5K7D85HGB31870');
var_dump((string) $vincode);