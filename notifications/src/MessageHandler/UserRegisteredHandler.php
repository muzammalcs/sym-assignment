<?php

namespace App\MessageHandler;

use App\Message\UserRegistered;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserRegisteredHandler implements MessageHandlerInterface
{
    public function __invoke(UserRegistered $message)
    {
        $data = [
            'email' => $message->getEmail(),
            'firstName' => $message->getFirstName(),
            'lastName' => $message->getLastName(),
        ];

        // Log user data
        file_put_contents('../var/log/notifications.log', json_encode($data) . PHP_EOL, FILE_APPEND);
    }
}
