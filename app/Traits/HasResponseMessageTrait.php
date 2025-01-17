<?php

namespace App\Traits;

trait HasResponseMessageTrait
{
    public function setResponseMessage(string $message): void
    {
        app('request')->attributes->set('responseMessage', $message);
    }
}
