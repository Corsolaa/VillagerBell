<?php

declare(strict_types=1);

namespace VillagerBell\Api\Email;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class EmailDto
{
    #[Constraints\Email(message: "That is not a valid email address")]
    private string $to;

    private string $subject;
    private ?string $body;

    private ?string $template;

    #[Constraints\Type(type: 'array', message: 'context needs to be array')]
    private ?array $context = [];

    #[Constraints\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        // "body" or "template" — at least one must be set
        if (empty($this->body) && empty($this->template)) {
            $context->buildViolation('either body or template must be provided')
                ->atPath('body or template')
                ->addViolation();
        }
    }

    public function __construct(
        ?string $to = null,
        ?string $subject = null,
        ?string $body = null,
        ?string $template = null,
        array   $context = []
    )
    {
        $this->to = !empty($to) ? $to : 'bruno.bouwman4@gmail.com';
        $this->subject = !empty($subject) ? $subject : 'You have got mail!';
        $this->body = $body;
        $this->template = trim($template);
        $this->context = $context ?? [];
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }
}