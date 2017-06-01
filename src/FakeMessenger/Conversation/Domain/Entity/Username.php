<?php

namespace FakeMessenger\Conversation\Domain\Entity;

use FakeMessenger\Conversation\Domain\Exception\InvalidNameException;

class Username
{
    private $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw InvalidNameException::emptyName();
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}