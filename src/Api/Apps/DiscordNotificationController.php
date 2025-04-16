<?php

declare(strict_types=1);

namespace VillagerBell\Api\Apps;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DiscordNotificationController extends AbstractController
{
    #[Route('/api/discord', name: 'api_discord')]
    public function sendEmailNotification(): Response
    {
        return new Response('Discord notification endpoint.');
    }
}