<?php

namespace App\DTO;

class RestoreTemplateData extends TemplateData
{
    /**
     * Текст шаблона
     */
    private const TEMPLATE_TEXT = '{{.auth_code}} - код для восстановления пароля';

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
