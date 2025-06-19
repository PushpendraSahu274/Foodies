<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    //
    protected $guarded = [];
}

//flow -> request otp 
// verify otp
// provide him login 