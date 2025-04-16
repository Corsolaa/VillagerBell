<?php

declare(strict_types=1);

namespace VillagerBell\Api\Email;

use Symfony\Component\Validator\Constraints as Assert;

class EmailDto
{
    #[Assert\NotBlank]
    #[Assert\Email(message: "Please provide a valid email address.")]
    public string $to;

    #[Assert\NotBlank]
    public string $subject;

    #[Assert\NotBlank]
    public string $template;

    public array $context = [];
}