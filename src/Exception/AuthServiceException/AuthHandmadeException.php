<?php

namespace App\Exception\AuthServiceException;

use Exception;
use Throwable;

class AuthHandmadeException extends Exception
{
    /**
     * @var array
     */
    private array $errors;

    /**
     * @param string           $message
     * @param array            $errors
     * @param int              $code
     * @param Throwable | null $previous
     */
    public function __construct(
        string $message = "",
        array $errors = [],
        int $code = 0,
        Throwable $previous = null
    ) {
        $message = empty($message) ? json_encode($errors) : $message;

        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
