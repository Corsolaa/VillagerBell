<?php

declare(strict_types=1);

namespace VillagerBell\Api\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailNotificationController extends AbstractController
{
    public function __construct(private readonly EmailNotificationService $emailNotificationService)
    {
    }

    #[Route('/api/email', name: 'api_email')]
    public function sendEmailNotification(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $to       = $data['to'] ?? '';
        $subject  = $data['subject'] ?? '';
        $template = $data['template'] ?? '';
        $context  = $data['context'] ?? [];

        $success = $this->emailNotificationService->send($to, $subject, $template, $context);

        return new JsonResponse(
            ['success' => $success, 'message' => $success ? 'Email sent ✅' : 'Email notification failed 😢'],
            $success ? 200 : 500
        );
    }
}