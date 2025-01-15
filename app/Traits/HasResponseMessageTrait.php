<?php

namespace App\Traits;

trait HasResponseMessageTrait
{
    /**
     * Définit le message custom sur la requête PRINCIPALE.
     *
     * @param string $message
     * @return void
     */
    public function setResponseMessage(string $message): void
    {
        // La requête "officielle" de Laravel
        app('request')->attributes->set('responseMessage', $message);
    }
}
