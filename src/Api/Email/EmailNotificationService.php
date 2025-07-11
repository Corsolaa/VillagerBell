<?php

declare(strict_types=1);

namespace VillagerBell\Api\Email;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Throwable;
use Twig\Environment as Twig;

readonly class EmailNotificationService
{
    public function __construct(
        private MailerInterface $mailInterface,
        private Twig            $twig,
        private LoggerInterface $logger)
    {
    }

    public function send(EmailDto $emailDto): bool
    {
        try {
            $body = $this->twig->render($emailDto->template, $emailDto->context);

            $email = (new Email())
                ->from($from ?? 'noreply@example.com')
                ->to($emailDto->to)
                ->subject($emailDto->subject)
                ->html($body);

            $this->mailInterface->send($email);
            return true;
        } catch (Throwable $e) {
            $this->logger->error('Email notification send failed: ' . $e->getMessage(), ['exception' => $e]);
            return false;
        }
    }
}