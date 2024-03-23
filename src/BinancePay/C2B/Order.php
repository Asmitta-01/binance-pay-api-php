<?php

namespace BinancePay\C2B;

use BinancePay\Core\Model\Buyer;
use BinancePay\Core\Model\Goods;

trait Order
{

    /**
     * Create order API Version 3 used for merchant/partner to initiate acquiring order.
     * 
     * @param string $terminalType Terminal type of which the merchant service applies to. Valid values are: APP, WEB, WAP, MINI_PROGRAM, OTHERS. Default WEB
     * @param array $goodsList Good details, an array of \BinancePay\Core\Model\Goods
     * @param float $amount Order amount
     * @param string $description Order description
     * @param Buyer $buyer User who will pay the order
     * @param string $currency Valid currency, must be in uppercase	Currency to query, for e.g, "USDT"
     * @param string $returnUrl The URL to redirect to when the payment is successful. Url must begin with HTTP. Only one parameter is allowed per URL
     * @param string $cancelUrl The URL to redirect to when the payment is failed. Url must begin with HTTP. Only one parameter is allowed per URL
     * @param array $supportPayCurrency SupportPayCurrency determines the currencies that a customer is allowed to use to pay for the order. If not specified, all Binance Pay supported currencies will be allowed.
     * @param string $passThroughInfo Pass through info, returned as-is in query order API and payment webhook notification
     * 
     * @return array Format: https://developers.binance.com/docs/binance-pay/api-order-create-v3#orderresult
     * 
     * @link https://developers.binance.com/docs/binance-pay/api-order-create-v3
     */
    public function createOrder(
        string $currency = 'USDT',
        float $amount,
        string $description,
        string $terminalType = 'WEB',
        array $goodsList,
        string $merchantTradeNumber,
        ?Buyer $buyer,
        ?string $returnUrl,
        ?string $cancelUrl,
        array $supportPayCurrency = [],
        ?string $passThroughInfo
    ): ?array {
        $method = 'POST';
        $path = '/binancepay/openapi/v3/order';
        $body = [
            "env" => [
                "terminalType" => $terminalType
            ],
            "merchantTradeNo" => $merchantTradeNumber,
            "orderAmount" => $amount,
            "currency" => $currency,
            "goods" => array_filter($goodsList, fn ($g) => $g instanceof Goods),
            "description" => $description
        ];

        $additionalParams = [
            "buyer" => $buyer?->toArray(),
            "passThroughInfo" => $passThroughInfo,
            "cancelUrl" => $cancelUrl,
            "returnUrl" => $returnUrl,
        ];

        $body = array_merge($body, array_filter($additionalParams));

        if (!empty($supportPayCurrency)) {
            $body["supportPayCurrency"] = implode(',', $supportPayCurrency);
        }


        $res = $this->processRequest($path, $method, $body);
        if ($res != null && $res['status'] == 'SUCCESS') {
            return $res['data'];
        }
        return null;
    }

    /**
     * Query order API used for merchant to query order status.
     * 
     * @param string $merchantTradeNo The order id, Unique identifier for the request. Will be ignored if prepayId already provided
     * 
     * @return array Format: https://developers.binance.com/docs/binance-pay/api-order-query-v2#queryorderresult
     * 
     * @link https://developers.binance.com/docs/binance-pay/api-order-query-v2
     */
    public function queryOrder(string $merchantTradeNo): ?array
    {
        $path = '/binancepay/openapi/v2/order/query';
        $body = [
            "merchantTradeNo" => $merchantTradeNo
        ];

        $res = $this->processRequest($path, 'POST', $body);
        if ($res != null && $res['status'] == 'SUCCESS') {
            return $res['data'];
        }
        return null;
    }

    /**
     * You can use the “Closer Order” API to cancel an open unpaid transaction.
     * By default an order will expire in an hour upon creation. This expiry time can also be customized by you, just set the orderExpireTime accordingly in milliseconds when calling the Create Order API.
     * This function allows you to manual expiry and close an active order
     * 
     * @param string $merchantTradeNo The order id, Unique identifier for the request.
     * 
     * @link https://developers.binance.com/docs/binance-pay/api-order-query-v2
     */
    public function closeOrder(string $merchantTradeNo): ?bool
    {
        $path = '/binancepay/openapi/v2/order/close';
        $body = [
            "merchantTradeNo" => $merchantTradeNo
        ];

        $res = $this->processRequest($path, 'POST', $body);
        return $res != null ? $res['status'] == 'SUCCESS' : null;
    }

    /**
     * You can use the “Closer Order” API to cancel an open unpaid transaction.
     * By default an order will expire in an hour upon creation. This expiry time can also be customized by you, just set the orderExpireTime accordingly in milliseconds when calling the Create Order API.
     * This function allows you to manual expiry and close an active order
     * 
     * @param string $refundRequestId The unique ID assigned by the merchant to identify a refund request.The value must be same for one refund request.
     * @param string $prepayId The unique ID assigned by Binance for the original order to be refunded.
     * @param string $reason
     * @param float $amount You can perform multiple partial refunds, but their sum should not exceed the order amount.
     * 
     * @return bool **True** if the refund has been done and **False** otherwise
     * 
     * @link https://developers.binance.com/docs/binance-pay/api-order-refund
     */
    public function refundOrder(
        string $refundRequestId,
        string $prepayId,
        float $amount,
        string $reason = ""
    ): ?bool {
        $path = '/binancepay/openapi/v2/order/close';
        $body = [
            "refundRequestId" => $refundRequestId,
            "prepayId" => $prepayId,
            "refundAmount" => $amount,
            "refundReason" => $reason
        ];

        $res = $this->processRequest($path, 'POST', $body);
        return $res != null ? $res['status'] == 'SUCCESS' : null;
    }
}
