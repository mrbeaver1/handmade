<?php

namespace App\Services\AuthServiceApi;

use GuzzleHttp\Client;

class AuthServiceApi
{
    /**
     * HTTP-коды ответов
     */
    private const HTTP_OK = 200;
    private const HTTP_CREATED = 201;
    private const HTTP_BAD_REQUEST = 400;
    private const HTTP_UNAUTHORIZED = 401;

    /**
     * Запрос на создание токена
     */
    private const ENCODE = '/encode';

    /**
     * Запрос на декодирование токена
     */
    private const DECODE = '/decode';

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var array
     */
    private array $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * @param string $authServiceBasePath
     */
    public function __construct(string $authServiceBasePath)
    {
        $this->client = new Client([
            'base_uri' => $authServiceBasePath,
            'http_errors' => false,
            'headers' => $this->headers,

        ]);
    }

    public function createAuthToken(int $userId, string $email, string $userRole): array
    {

    }

    private function post(string $uri, array $body): array
    {
        $result = $this->client->post($uri,['json' => $body]);

        $responseBody = $result->getBody()->getContents();
    }
}
