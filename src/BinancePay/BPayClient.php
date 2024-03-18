<?php

namespace BinancePay;

use BinancePay\Util\Word;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

/**
 * Base class for client implementation
 */
abstract class BPayClient
{

    public function __construct(

        private string $baseURL,

        private string $key,

        private string $secret,

        private $logger
    ) {
        $this->logger ??= new LoggerInterface();
    }

    /**
     * @link https://merchant.binance.com/en/docs/getting-started#how-to-generate-api-signature
     */
    private function getSignature(int $timestamp, string $nonce, array $body = []): string
    {
        $body = empty($body) ? '' : json_encode($body);
        $payload = $timestamp . "\n" . $nonce . "\n" . $body . "\n";
        return strtoupper(hash_hmac('SHA512', $payload, $this->secret));
    }

    private function getHeaders(array $body): array
    {
        $time = round(microtime(true) * 1000);
        $nonce = Word::getRandomWord();
        $signature = $this->getSignature(timestamp: $time, nonce: $nonce, body: $body);

        return [
            'content-type' => 'application/json',
            'BinancePay-Certificate-SN' => $this->key,
            'BinancePay-Signature' => $signature,
            'BinancePay-Timestamp' => $time,
            'BinancePay-Nonce' => $nonce
        ];
    }


    protected function processRequest(string $path, string $method = 'GET', ?array $body = null): ?array
    {
        $options['headers'] = $this->getHeaders($body);
        if ($body != null) {
            $options['body'] = json_encode($body);
        }

        try {
            $client = new Client();
            $response = $client->request($method, $this->baseURL . $path, $options);
            return json_decode($response->getBody(), true);
        } catch (\Exception $th) {
            $this
                ->logger
                ->warning('Binance Pay::Request ' . $method . ' to ' . $path . ' failed : ' . $th->getMessage());
            return null;
        }
    }
}
