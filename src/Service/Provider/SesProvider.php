<?php

namespace App\Service\Provider;

use App\Service\Provider\MailerProvider;

class SesProvider implements MailerProvider
{
    private $email;
    private $message;

    public function send($email, $message)
    {
        return true; // TODO
    }
}