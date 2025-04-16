<?php

declare(strict_types=1);

namespace VillagerBell\Api\Apps;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TelegramNotificationController extends AbstractController
{
    #[Route('/api/telegram', name: 'api_telegram')]
    public function sendEmailNotification(): Response
    {
        return new Response('Telegram notification endpoint.');
    }
}