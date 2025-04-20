<?php

declare(strict_types=1);

namespace VillagerBell\Api\Email;

use Symfony\Component\Validator\Constraints;

class EmailDto
{
    #[Constraints\NotBlank]
    #[Constraints\Email(message: "the email '{{ value }}' is not valid")]
    public string $to;

    #[Constraints\NotBlank(message: "subject cannot be blank")]
    public string $subject;

    #[Constraints\NotBlank(message: "template key cannot be blank")]
    public string $template;

    #[Constraints\Type(type: 'array', message: 'context needs to be array')]
    public ?array $context = [];
}