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
