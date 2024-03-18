# Binance Pay Helper PHP

This is a helper to use [Binance Pay Api](https://developers.binance.com/docs/binance-pay/introduction) in your php projects.

## Installation

```shell

composer require asmitta-01/binance-pay-api-php

```

## How to use

```php

require_once 'vendor/autoload.php';

$client = new \BinancePay\C2B(apiKey: $key, secret: $secret);
$response = $client->getWalletBalance();
print_r($response);

```
