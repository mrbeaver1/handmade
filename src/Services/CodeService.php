<?php

namespace App\Services;

use App\DTO\RegisterData;
use App\DTO\RegisterInterface;
use App\DTO\RegisterTemplateData;
use App\DTO\RestoreTemplateData;
use App\Entity\Code;
use App\Repository\CodeRepositoryInterface;
use App\VO\Email;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use App\VO\Email as EntityEmail;

class CodeService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CodeRepositoryInterface
     */
    private CodeRepositoryInterface $codeRepository;

    /**
     * @var string
     */
    private string $smtpHost;

    /**
     * @var string
     */
    private string $smtpPort;

    /**
     * @var string
     */
    private string $smtpEncription;

    /**
     * @var string
     */
    private string $smtpUserName;

    /**
     * @var string
     */
    private string $smtpUserPass;

    /**
     * @var string
     */
    private string $authCodeActiveTime;

    /**
     * Шаблон заголовка для кода регистрации пользователя
     */
    private const REGISTER_CODE_TITLE = 'Код для регистрации';

    /**
     * Шаблон заголовка для кода восстановления
     */
    private const RESTORE_CODE_TITLE = 'Код для восстановления';

    /**
     * @param EntityManagerInterface  $em
     * @param CodeRepositoryInterface $codeRepository
     * @param string                  $smtpHost
     * @param string                  $smtpPort
     * @param string                  $smtpEncription
     * @param string                  $smtpUserName
     * @param string                  $smtpUserPass
     * @param string                  $authCodeActiveTime
     */
    public function __construct(
        EntityManagerInterface $em,
        CodeRepositoryInterface $codeRepository,
        string $smtpHost,
        string $smtpPort,
        string $smtpEncription,
        string $smtpUserName,
        string $smtpUserPass,
        string $authCodeActiveTime
    ) {
        $this->em = $em;
        $this->codeRepository = $codeRepository;
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
        $this->smtpEncription = $smtpEncription;
        $this->smtpUserName = $smtpUserName;
        $this->smtpUserPass = $smtpUserPass;
        $this->authCodeActiveTime = $authCodeActiveTime;
    }

    /**
     * @param RegisterInterface $registerData
     *
     * @throws ORMException
     */
    public function sendSmsCode(RegisterInterface $registerData): void
    {
        $email = $registerData->getEmail();

        $this->deactivateCodeByEmail($email);

        $code = new Code(
            $email,
            rand(1000, 9999),
            new DateTimeImmutable()
        );

        $this->codeRepository->add($code);
        $this->em->flush();

        if ($registerData instanceof RegisterData) {
            $template = new RegisterTemplateData($code->getCode());

            $title = self::REGISTER_CODE_TITLE;
        } else {
            $template = new RestoreTemplateData($code->getCode());

            $title = self::RESTORE_CODE_TITLE;
        }

        $transport = $this->getSmtpTransport();
        $mailer = new Swift_Mailer($transport);
        $mail = (new Swift_Message($title))
            ->setFrom($transport->getUsername())
            ->setTo([$email->getValue()])
            ->setBody($template->getMessage());
        $mailer->send($mail);
    }

    /**
     * @param EntityEmail $email
     */
    public function deactivateCodeByEmail(EntityEmail $email): void
    {
        $code = $this->codeRepository->findActiveByEmail($email);

        if (!empty($code)) {
            $code->deactivate();
            $this->em->flush();
        }
    }

    /**
     * @return Swift_SmtpTransport
     */
    private function getSmtpTransport(): Swift_SmtpTransport
    {
        return (new Swift_SmtpTransport($this->smtpHost, $this->smtpPort, $this->smtpEncription))
            ->setUsername($this->smtpUserName)
            ->setPassword($this->smtpUserPass);
    }

    /**
     * @param Email  $email
     * @param string $verifiableCode
     *
     * @return bool
     *
     * @throws Exception
     */
    public function isSmsCodeValid(Email $email, string $verifiableCode): bool
    {
        $code = $this->codeRepository->findActiveByEmailAndValue($email, $verifiableCode);

        // Проверяем, есть ли введённый код в БД для данного мобильного номера
        if (empty($code)) {
            return false;
        }

        // Проверка не просорочен ли код
        // Время действия кода - 1 час
        return (new DateTime($this->authCodeActiveTime)) < $code->getCreatedAt();
    }
}
