<?php
require '../vendor/autoload.php';

use Unipile\UnipileSDK;

$baseUri = 'https://apiXXX.unipile.com:XXXXX';
$token = 'XXX';
$unipileSDK = new UnipileSDK($baseUri, $token);