<?php

namespace FakeMessenger\Conversation\Domain\Entity;

use FakeMessenger\Conversation\Domain\Adapter\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class Conversation
{
    private $id;

    /**
     * @Serializer\Type("DateTimeImmutable")
     */
    private $createdDate;
    private $messages;
    private $from;

    public function __construct(ConversationId $id, User $from)
    {
        $this->createdDate = new \DateTimeImmutable();
        $this->messages = new ArrayCollection();
        $this->from = $from;
        $this->id = $id;
    }

    public static function create(string $username)
    {
        return new self(
            ConversationId::generate(),
            new User(new Username($username))
        );
    }

    public function getId(): ConversationId
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getCreatedDate(): \DateTimeImmutable
    {
        return $this->createdDate;
    }

    /**
     * @return ArrayCollection|Message[]
     */
    public function getMessages(): ArrayCollection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): Conversation
    {
        $this->messages->add($message);

        return $this;
    }

    public function removeMessage(Message $message): Conversation
    {
        $this->messages->removeElement($message);

        return $this;
    }
}