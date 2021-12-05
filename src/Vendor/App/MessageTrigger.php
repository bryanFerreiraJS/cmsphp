<?php


namespace Vendor\App;


class MessageTrigger
{
    public static function setMessage(string $message): void
    {
        $_SESSION['message'] = htmlspecialchars($message);
    }

    public static function hasMessage(): bool
    {
        return isset($_SESSION['message']);
    }

    public static function getMessage()
    {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        }
    }
}