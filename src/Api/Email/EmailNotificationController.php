<?php

declare(strict_types=1);

namespace VillagerBell\Api\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment as Twig;

class EmailNotificationController extends AbstractController
{
    public function __construct(
        private readonly EmailNotificationService $emailNotificationService
    )
    {
    }

    #[Route('/api/email', name: 'api_email')]
    public function sendEmailNotification(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Twig $twig
    ): Response
    {
        $input = $serializer->deserialize($request->getContent(), EmailDto::class, 'json');
        $errors = $validator->validate($input);
        $errorMessages = [];

        foreach ($errors as $violation) {
            $errorMessages[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        if ($twig->getLoader()->exists($input->template) === false) {
            $errorMessages[] = [
                'field' => 'template',
                'message' => "template '{$input->template}' doesn't exist"
            ];
        }

        if (empty($errorMessages) === false) {
            return new JsonResponse(['status' => 'error', 'errors' => $errorMessages], 400);
        }

        $success = $this->emailNotificationService->send($input);

        return new JsonResponse(
            ['success' => $success, 'message' => $success ? 'Email sent ✅' : 'Email notification failed 😢'],
            $success ? 200 : 500
        );
    }
}