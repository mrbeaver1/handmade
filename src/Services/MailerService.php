<?php

namespace App\Services;

use App\DTO\RegisterData;
use App\DTO\RegisterInterface;
use App\DTO\RegisterTemplateData;
use App\DTO\RestoreTemplateData;
use App\Entity\Code;
use App\Repository\CodeRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\VO\Email as EntityEmail;

class MailerService
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
    private string $mailerSenderEmail;

    /**
     * @var MailerInterface
     */
    private MailerInterface $mailerInterface;

    /**
     * @param EntityManagerInterface  $em
     * @param CodeRepositoryInterface $codeRepository
     * @param string                  $mailerSenderEmail
     * @param MailerInterface         $mailerInterface
     */
    public function __construct(
        EntityManagerInterface $em,
        CodeRepositoryInterface $codeRepository,
        string $mailerSenderEmail,
        MailerInterface $mailerInterface
    ) {
        $this->em = $em;
        $this->codeRepository = $codeRepository;
        $this->mailerSenderEmail = $mailerSenderEmail;
        $this->mailerInterface = $mailerInterface;
    }

    /**
     * @param RegisterInterface $registerData
     * @throws ORMException
     * @throws TransportExceptionInterface
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
        } else {
            $template = new RestoreTemplateData($code->getCode());
        }

        $sendingEmail = (new Email())->from($this->mailerSenderEmail)
            ->to($email->getValue())
            ->text($template);

        $this->mailerInterface->send($sendingEmail);
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
}
