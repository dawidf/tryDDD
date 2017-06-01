<?php

namespace FakeMessenger\Common\Domain\Exception;

class NotFountException extends \Exception
{
    public static function pageNotFound()
    {
        return new self('Page not found');
    }
}