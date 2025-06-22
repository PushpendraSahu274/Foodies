<?php

namespace App\Observers\Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartObserver
{
    //
    public function saving(){
        Log::info('saving the cart__for__'.Auth::user()->id.'_'.now()->format("H:i:s"));
    }

    public function saved(){
        Log::info('saved the cart__for__'.Auth::user()->id.'_'.now()->format("H:i:s"));
    }

    public function updating(){
        Log::info('updating the cart__for__'.Auth::user()->id.'_'.now()->format("H:i:s"));
    }

    public function updated(){
        Log::info('updated the cart__for__'.Auth::user()->id.'_'.now()->format("H:i:s"));
    }
    
}
