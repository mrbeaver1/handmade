<?php

namespace App\DTO;

use App\VO\SmsTemplate;

class SendSmsData
{
    /**
     * @var SmsTemplate
     */
    private SmsTemplate $smsTemplate;

    /**
     * @param SmsTemplate $smsTemplate
     */
    public function __construct(SmsTemplate $smsTemplate)
    {
        $this->smsTemplate = $smsTemplate;
    }

    /**
     * @return SmsTemplate
     */
    public function getSmsTemplate(): SmsTemplate
    {
        return $this->smsTemplate;
    }
}
