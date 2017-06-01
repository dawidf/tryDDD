<?php

namespace FakeMessenger\Common\Domain;

class UUID
{
    protected $id;

    public function __construct(string $value)
    {
        $this->id = $value;
    }

    function __toString(): string
    {
        return (string)$this->id;
    }

    public function isEquals(UUID $id): bool
    {
        return $this->id === $id->id;
    }
}