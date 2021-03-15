<?php

namespace App\DTO;

class RegisterTemplateData extends TemplateData
{
    /**
     * Текст шаблона
     */
    private const TEMPLATE_TEXT = '{{.auth_code}} - Код подтверждения email';

    /**
     * @var string
     */
    private string $authCode;

    /**
     * @param string $authCode
     */
    public function __construct(string $authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * @return array
     */
    protected function getVars(): array
    {
        return [
            'auth_code' => $this->authCode,
        ];
    }

    /**
     * @return string
     */
    protected function getTemplateText(): string
    {
        return self::TEMPLATE_TEXT;
    }
}
