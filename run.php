<?php

require __DIR__ . '/vendor/autoload.php';

$klaus = new \KlausShow\Human('Klaus', '555-7777');
$maria = new \KlausShow\Human('Maria', '777-5555');

$hr = new \KlausShow\HR(new Monolog\Logger('HR'));

// 1. Let's hire Klaus
$hr->hire($klaus);

// 2. Merry Klaus to Maria, seriously, it's time
$klaus->merry($maria);

// 3. Maria decided to change her phone number
$maria->setPhoneNumber('9999-444444');
$maria->setPhoneNumber('8888-543678');

