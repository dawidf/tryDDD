<?php

namespace FakeMessenger\Conversation\Application\Command;

use FakeMessenger\Conversation\Domain\Entity\Conversation;
use Symfony\Component\Validator\Constraints as Assert;

class CreateMessageCommand
{
    private $conversation;
    private $sendDate;

    /**
     * @Assert\NotNull()
     * @Assert\Email()
     */
    private $content;

    public function __construct(
        Conversation $conversation, \DateTimeImmutable $sendDate, string $content
    )
    {
        $this->conversation = $conversation;
        $this->sendDate = $sendDate;
        $this->content = $content;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function getSendDate(): \DateTimeImmutable
    {
        return $this->sendDate;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}