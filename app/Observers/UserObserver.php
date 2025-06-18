<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    //
    public function saving(User $user){
        if($user->isDirty('email')){
             $user->email_verified_at = null;
        }
    }
}   
