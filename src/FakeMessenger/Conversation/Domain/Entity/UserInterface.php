<?php

namespace FakeMessenger\Conversation\Domain\Entity;

interface UserInterface
{
    public function getName(): Username;
}