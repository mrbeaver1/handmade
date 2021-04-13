<?php

namespace App\Services\AuthServiceApi;

use App\DTO\DecodedTokenData;
use App\Exception\AuthServiceException\AuthHandmadeException;
use App\Exception\AuthServiceException\BadRequestException;
use App\Exception\AuthServiceException\UnauthorizedException;
use App\VO\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

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
     * @param int $userId
     * @param string $email
     * @param string $userRole
     *
     * @return Token
     *
     * @throws AuthHandmadeException
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws GuzzleException
     */
    public function createAuthToken(int $userId, string $email, string $userRole): Token
    {
        $body = [
            'user_id' => $userId,
            'email' => $email,
            'user_role' => $userRole,
        ];

        $response = $this->post(self::ENCODE, $body);

        return new Token($response['token']);
    }

    /**
     * @param string $token
     *
     * @return DecodedTokenData
     *
     * @throws AuthProdavayException
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws Exception
     */
    public function decodeToken(string $token): DecodedTokenData
    {
        $body = ['token' => $token];

        $result = $this->get(self::DECODE,$body);


        return new DecodedTokenData(
            $result['user_id'],
            $result['user_role'],
            $result['email']
        );
    }

    private function get(string $uri, array $body): array
    {
        $result = $this->client->get($uri, ['query' => $body]);

        $responseBody = $result->getBody()->getContents();

        return $this->getResponse($result, $responseBody);
    }

    /**
     * @param string $uri
     * @param array  $body
     *
     * @return array
     *
     * @throws AuthHandmadeException
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws GuzzleException
     */
    private function post(string $uri, array $body): array
    {
        $result = $this->client->post($uri,['json' => $body]);

        $responseBody = $result->getBody()->getContents();

        return $this->getResponse($result, $responseBody);
    }

    /**
     * @param ResponseInterface $response
     * @param string            $responseBody
     *
     * @return array
     *
     * @throws AuthHandmadeException
     * @throws BadRequestException
     * @throws UnauthorizedException
     */
    private function getResponse(ResponseInterface $response, string $responseBody): array
    {
        $content = json_decode($responseBody, true);

        if (empty($content)) {
            throw new AuthHandmadeException("Нет данных в теле ответа: $responseBody");
        }

        switch ($response->getStatusCode()) {
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
