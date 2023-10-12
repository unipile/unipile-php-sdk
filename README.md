# Unipile PHP SDK

The PHP SDK provides you tools to interact with Unipile’s API with ease. To have more informations about how Unipile’s API works and how to use it, please take a look at the following resources.

[Unipile API guide](https://developer.unipile.com/docs)

[Unipile API reference](https://developer.unipile.com/reference)


# Installation

```
  composer require unipile/unipile-php-sdk
```

# Usage

```PHP
<?php
require '../vendor/autoload.php';

use Unipile\UnipileSDK;

$baseUri = 'https://apiXXX.unipile.com:XXX';
$token = 'XXXX';
$unipileSDK = new UnipileSDK($baseUri, $token);

$accounts = $unipileSDK->Account->list();
```
