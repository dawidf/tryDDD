<?php

namespace FakeMessenger\Conversation\Application\Command;


class CreateConversationCommand
{
    private $from;
    private $id;

    public function __construct(string $id, string $from)
    {
        $this->from = $from;
        $this->id = $id;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getId(): string
    {
        return $this->id;
    }
}