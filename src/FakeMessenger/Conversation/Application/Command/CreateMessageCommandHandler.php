<?php

namespace FakeMessenger\Conversation\Application\Command;

use FakeMessenger\Conversation\Domain\Conversations;
use FakeMessenger\Conversation\Domain\Entity\Message;
use FakeMessenger\Conversation\Domain\Messages;

class CreateMessageCommandHandler
{
    private $messages;

    public function __construct(Messages $messages)
    {
        $this->messages = $messages;
    }

    public function handle(CreateMessageCommand $command)
    {
        $message = new Message(
            $command->getConversation(),
            $command->getSendDate(),
            $command->getContent()
        );

        $this->messages->add($message);

        return $message;
    }
}