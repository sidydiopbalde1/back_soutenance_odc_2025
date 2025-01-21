<?php

namespace App\Services\Interfaces;
use App\Models\User;

interface IMail {

    public function sendEmail(User $user, $subject);
}