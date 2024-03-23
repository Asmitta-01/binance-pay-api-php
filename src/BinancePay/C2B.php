<?php

namespace BinancePay;

use BinancePay\BPayClient;

class C2B extends BPayClient
{
    use C2B\Wallet;
    use C2B\Order;

    public function __construct(?string $baseURL, string $apiKey, string $secret, $logger)
    {
        $baseURL ??=  'https://bpay.binanceapi.com';
        parent::__construct(baseURL: $baseURL, key: $apiKey, secret: $secret, logger: $logger);
    }
}
