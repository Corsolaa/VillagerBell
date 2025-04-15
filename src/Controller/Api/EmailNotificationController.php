<?php

declare(strict_types=1);

namespace VillagerBell\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailNotificationController extends AbstractController
{
    #[Route('/api/email', name: 'api_email')]
    public function sendEmailNotification(): Response
    {
        return new Response('Email notification endpoint.');
    }
}