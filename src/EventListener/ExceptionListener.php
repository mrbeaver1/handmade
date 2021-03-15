<?php

namespace App\EventListener;

use App\Exception\ApiHttpException\ApiExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use GuzzleHttp\Exception\ConnectException;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $uri = $event->getRequest()->getUri();

        if ($exception instanceof ConnectException) {
            $response = new JsonResponse(
                [
                    'data' => [
                        'errors' => [
                            [
                                'code' => 'auth-center-error',
                                'message' => 'Недоступен авторизационный центр',
                            ],
                        ],
                    ],
                ],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        } elseif ($exception instanceof ApiExceptionInterface) {
            $responseErrors = [];

            foreach ($exception->getErrors() as $field => $errorMessage) {
                $fieldName = is_numeric($field) ? null : $field;
                $errorMessage = is_array($errorMessage) ? json_encode($errorMessage) : $errorMessage;

                $responseErrors['errors'][] = [
                    // В Api в это поле требуется передавать текстовый код ошибки, делаем это через message
                    'code' => $exception->getApiErrorCode()->getValue(),
                    'message' => "$fieldName: $errorMessage",
                    // Если ключ не содержит название поля, определяем field как null
                    'field' => $fieldName
                ];
            }

            $response = new JsonResponse(
                ['data' => $responseErrors],
                $exception->getHttpCode()->getValue()
            );
        } elseif ($exception instanceof NotFoundHttpException) {
            $response = new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } elseif (!strpos($uri, 'api')) {
            $response = new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } elseif ($exception instanceof BadRequestHttpException) {
            $response = new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } else {
            $response = new JsonResponse(
                [
                    'data' => [
                        'errors' => [
                            [
                                'code' => 'internal-server-error',
                                'message' => $exception->getMessage(),
                                'line' => $exception->getLine(),
                                'file' => $exception->getFile(),
                            ],
                        ],
                    ],
                ],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        if (!empty($response)) {
            $event->setResponse($response);
        }
    }
}
