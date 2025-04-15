<?php

declare(strict_types=1);

namespace VillagerBell\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PwaNotificationController extends AbstractController
{
    #[Route('/api/pwa', name: 'api_pwa')]
    public function sendEmailNotification(): Response
    {
        return new Response('Pwa notification endpoint.');
    }
}