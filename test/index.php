<?php

require_once '../vendor/autoload.php';


$get = $_GET;

$testAnonymousClient = new LibAnimeList\AnimeListClient(LibAnimeList\AnimeListClient::createCredentials($get['username'], $get['password']));

echo $testAnonymousClient->verifyCredentials() ? 'Jaaa' : 'Neee';