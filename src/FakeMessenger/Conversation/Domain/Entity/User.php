<?php

namespace FakeMessenger\Conversation\Domain\Entity;

class User implements UserInterface
{
    private $name;
    private $id;

    public function __construct(Username $name)
    {
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Username
    {
        return $this->name;
    }
}