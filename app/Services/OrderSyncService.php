<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OrderSyncService
{
    protected Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(['base_uri' => 'https://api.anydomainhere.com/']);
    }

    public function syncOrders(array $orders): array
    {
        $responses = [];

        foreach ($orders as $order) {
            try {
                $response = $this->httpClient->post('/orders', [
                    'json' => $order,
                ]);
                $responses[] = json_decode($response->getBody()->getContents(), true);
            } catch (RequestException $e) {

                $responses[] = [
                    'error' => true,
                    'message' => $e->getMessage(),
                    'order' => $order,
                ];
            }
        }

        return $responses;
    }
}
