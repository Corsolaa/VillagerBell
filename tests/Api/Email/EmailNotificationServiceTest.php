<?php

declare(strict_types=1);

namespace VillagerBell\Tests\Api\Email;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use VillagerBell\Api\Email\EmailNotificationService;

#[CoversClass(EmailNotificationService::class)]
class EmailNotificationServiceTest extends TestCase
{
    public function testSend(): void
    {
        $twig   = $this->createMock(Environment::class);
        $mailer = $this->createMock(MailerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $twig->method('render')
            ->willReturn('<p>Test email</p>');

        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(Email::class));

        $logger->expects($this->never())->method('error');

        $service = new EmailNotificationService($mailer, $twig, $logger);

        $this->assertTrue($service->send(
            'to@example.com',
            'Test Subject',
            'email/template.html.twig',
            ['name' => 'John']
        ));
    }

    public function testSendException(): void
    {
        $twig   = $this->createMock(Environment::class);
        $mailer = $this->createMock(MailerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $twig->method('render')
            ->willReturn('<p>Test email</p>');

        $mailer->method('send')
            ->willThrowException(new \Exception('Mailer failed'));

        $logger->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Email notification send failed'));

        $service = new EmailNotificationService($mailer, $twig, $logger);

        $this->assertFalse($service->send(
            'to@example.com',
            'Test Subject',
            'email/template.html.twig',
            ['name' => 'John']
        ));
    }
}
