<?php

namespace common\services;

use frontend\modules\apiV1\models\request\CreateWebpushRequest;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SymfonyApiClient
{
    /**
     * @var Client
     */
    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    public function getRestaurants(): array
    {
        $response = $this->_client->get(
            '/api/v1/restaurants',
        );

        return \json_decode($response->getBody()->getContents(), true);
    }

    public function getMenu(int $restaurantId): array
    {
        $response = $this->_client->get(
            sprintf('/api/v1/restaurants/%d/menu', $restaurantId),
        );

        return \json_decode($response->getBody()->getContents(), true);
    }

    public function getRestaurantCategories(): array
    {
        $response = $this->_client->get('/api/v1/dictionaries/categories');

        return \json_decode($response->getBody()->getContents(), true);
    }

    public function createWebpush(CreateWebpushRequest $createWebpushRequest): void
    {
        $body = [
            'subscription' => [
                'endpoint' => $createWebpushRequest->endpoint,
                'keys' => $createWebpushRequest->keys
            ],
        ];

        $this->_client->post(
            '/api/webpush',
            [
                RequestOptions::JSON => $body,
            ]
        );
    }

    public function deleteWebpush(CreateWebpushRequest $createWebpushRequest): void
    {
        $body = [
            'subscription' => [
                'endpoint' => $createWebpushRequest->endpoint,
                'keys' => $createWebpushRequest->keys
            ],
        ];

        $this->_client->delete(
            '/api/webpush',
            [
                RequestOptions::JSON => $body,
            ]
        );
    }
}
