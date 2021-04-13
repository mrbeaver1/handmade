<?php

namespace App\Services\AuthServiceApi;

use App\Exception\AuthServiceException\AuthHandmadeException;
use App\Exception\AuthServiceException\BadRequestException;
use App\Exception\AuthServiceException\UnauthorizedException;
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

    /**
     * @param int    $userId
     * @param string $email
     * @param string $userRole
     *
     * @return string
     *
     * @throws AuthHandmadeException
     * @throws BadRequestException
     * @throws UnauthorizedException
     */
    public function createAuthToken(int $userId, string $email, string $userRole): string
    {
        $body = [
            'user_id' => $userId,
            'email' => $email,
            'user_role' => $userRole,
        ];

        $response = $this->post(self::ENCODE, $body);

        return $response['token'];
    }

    private function post(string $uri, array $body): array
    {
        $result = $this->client->post($uri,['json' => $body]);

        $responseBody = $result->getBody()->getContents();

        $content = json_decode($responseBody, true);

        if (empty($content)) {
            throw new AuthHandmadeException("Нет данных в теле ответа: $responseBody");
        }

        switch ($result->getStatusCode()) {
            case self::HTTP_OK:
            case self::HTTP_CREATED:
                return $content;
            case self::HTTP_BAD_REQUEST:
                if (is_array($content)) {
                    throw new BadRequestException($responseBody, $content);
                }

                throw new BadRequestException($content, [$content]);
                break;
            case self::HTTP_UNAUTHORIZED:
                if (is_array($content)) {
                    throw new UnauthorizedException($responseBody, $content);
                }

                throw new UnauthorizedException($content, [$content]);
                break;
            default:
                throw new AuthHandmadeException("Неожиданный код ответа: $responseBody");
        }
    }
}
