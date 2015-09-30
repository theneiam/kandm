<?php

require __DIR__ . '/vendor/autoload.php';

$logger = new Monolog\Logger('Runner');

$klaus = new \KlausShow\Human('Klaus', '555-5555');
$maria = new \KlausShow\Human('Maria', '777-7777');
$hr = new \KlausShow\HR(new Monolog\Logger('HR'));

// 1. Let's hire Klaus
if (!$hr->isEmployed($klaus)) {
    $logger->info('Klaus does not have a job. Let\'s hire him');
    $hr->hire($klaus);
    $logger->info($hr->isEmployed($klaus)
        ? 'Klaus have got a new job at HR'
        : 'Something is wrong... Klaus did not get a job'
    );
} else {
    $logger->info('Klaus already has a good job');
}

// 2. Merry Klaus to Maria, seriously, it's time
$logger->info('Klaus and Maria are about to get merried');
$klaus->merry($maria);
$logger->info('Klaus and Maria are merried now');

// 3. Maria decided to change her phone number
$logger->info('Maria changed her phone number');
$maria->setPhoneNumber('888-8888');
$logger->info('Maria phone is: ' . $klaus->getSpouse()->getPhoneNumber());

$logger->info('Maria changed her phone number again');
$maria->setPhoneNumber('999-9999');
$logger->info('Maria phone is: ' . $klaus->getSpouse()->getPhoneNumber());

