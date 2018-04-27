<?php

require_once '../vendor/autoload.php';

$username = $argv[1];
$password = $argv[2];

$client = new \LibAnimeList\Client(new \LibAnimeList\Model\Internal\Credentials($username, $password));

try {
    $client->verifyCredentials();
} catch (\Exception $e) {
    die('Oepsie poepsie!');
}

die ($client->getCredentials()->isValid() ? 'Valid' : 'Invalid');