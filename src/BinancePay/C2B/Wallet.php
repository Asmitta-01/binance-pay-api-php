<?php

namespace BinancePay\C2B;


trait Wallet
{

    /**
     * API used to query wallet balance.
     * 
     * @param string $wallet Binance wallet to query, currently supported enum values: FUNDING_WALLET, SPOT_WALLET
     * @param string $currency Valid currency, must be in uppercase	Currency to query, for e.g, "USDT"
     * 
     * @return array Format: https://developers.binance.com/docs/binance-pay/api-balance-query#assetqueryresp
     * 
     * @link https://developers.binance.com/docs/binance-pay/api-balance-query
     */
    public function getWalletBalance(string $currency = 'USDT', string $wallet = 'SPOT_WALLET'): ?array
    {
        $path = '/binancepay/openapi/balance';
        $body = [
            "wallet" => $wallet,
            "currency" => $currency
        ];

        $res = $this->processRequest($path, 'POST', $body);
        if ($res != null && $res['status'] == 'SUCCESS') {
            return $res['data'];
        }
        return null;
    }


    /**
     * API used to query one or more wallet balance.
     * 
     * @param string $wallet Binance wallet to query, currently supported enum values: FUNDING_WALLET, SPOT_WALLET
     * @param string $currency Valid currency, must be in uppercase	Currency to query, for e.g, "USDT"
     * 
     * @return array Format: https://developers.binance.com/docs/binance-pay/api-balance-query-v2#assetqueryrespv2
     * 
     * @link https://developers.binance.com/docs/binance-pay/api-balance-query-v2
     */
    public function getWalletBalanceV2(string $currency = 'USDT', string $wallet = 'SPOT_WALLET'): ?array
    {
        $path = '/binancepay/openapi/v2/balance';
        $body = [
            "wallet" => $wallet,
            "currency" => $currency
        ];

        $res = $this->processRequest($path, 'POST', $body);
        if ($res != null && $res['status'] == 'SUCCESS') {
            return $res['data'];
        }
        return null;
    }
}
