<?php

namespace App\Util\FlashBag;


class MessageFactory
{
    /**
     * @param string $constantName
     * @param mixed  ...$args
     *
     * @return string
     */
    public static function getMessage(string $constantName, ...$args): string
    {
        return vsprintf(constant(SystemMessage::class . '::' . $constantName), $args);
    }
}