<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = [];
    
    public function items(){
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function customer(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
}
