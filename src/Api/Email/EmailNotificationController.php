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
        Request             $request,
        SerializerInterface $serializer,
        ValidatorInterface  $validator,
        Twig                $twig
    ): Response
    {
        /** @var EmailDto $emailDto */
        $emailDto = $serializer->deserialize($request->getContent(), EmailDto::class, 'json');
        $errors = $validator->validate($emailDto);
        $errorMessages = [];

        foreach ($errors as $violation) {
            $errorMessages[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        if ($emailDto->getTemplate() != null &&
            $twig->getLoader()->exists('emails/' . $emailDto->getTemplate() . '.html.twig') === false) {
            $errorMessages[] = [
                'field' => 'template',
                'message' => "template '{$emailDto->getTemplate()}' doesn't exist"
            ];
        }

        if ($errorMessages != []) {
            return new JsonResponse(['status' => 'error', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(json_encode($emailDto));

//        $success = $this->emailNotificationService->send($emailDto);
//
//        return new JsonResponse(
//            ['success' => $success, 'message' => $success ? 'Email sent ✅' : 'Email notification failed 😢'],
//            $success ? 200 : 500
//        );
    }
}