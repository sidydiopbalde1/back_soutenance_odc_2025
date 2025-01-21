<?php

namespace App\Services\Mail;

use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Services\Interfaces\IMail;

class MailService implements IMail {
   
    public function sendEmail(User $user, $subject) {
       
        Mail::to($user->email)->send(new UserCreatedMail($user, $subject));
    }
}