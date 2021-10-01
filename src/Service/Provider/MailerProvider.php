<?php

namespace App\Service\Provider;

interface MailerProvider
{
  public function send ($email, $message);
}