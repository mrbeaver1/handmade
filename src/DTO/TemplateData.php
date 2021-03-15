<?php

namespace App\DTO;

/**
 * Родительский класс для шаблонов sms
 */
abstract class TemplateData
{
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return preg_replace(
            $this->getPatternVars(),
            $this->getReplacementVars(),
            $this->getTemplateText()
        );
    }

    /**
     * @return array
     */
    private function getPatternVars(): array
    {
        return array_map(
            function (string $key): string
            {
                return "~{{.$key}}~";
            },
            array_keys($this->getVars())
        );
    }

    /**
     * Возвращает переменные шаблона
     *
     * @return array
     */
    abstract protected function getVars(): array;

    /**
     * @return array
     */
    private function getReplacementVars(): array
    {
        return array_values($this->getVars());
    }

    /**
     * @return string
     */
    abstract protected function getTemplateText(): string;
}