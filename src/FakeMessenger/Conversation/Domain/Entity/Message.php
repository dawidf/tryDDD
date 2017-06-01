<?php

namespace FakeMessenger\Conversation\Domain\Entity;

use FakeMessenger\Conversation\Domain\Entity\Conversation;
use JMS\Serializer\Annotation as Serializer;

class Message
{
    private $id;
    private $conversation;

    /**
     * @Serializer\Type("DateTimeImmutable")
     */
    private $sendDate;
    private $content;

    public function __construct(
        Conversation $conversation, \DateTimeImmutable $sendDate, string $content
    )
    {
        $this->conversation = $conversation;
        $this->sendDate = $sendDate;
        $this->content = $content;
    }

    public function getId(): ?int
    {
        return $this->id;
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