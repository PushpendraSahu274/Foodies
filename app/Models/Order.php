<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function address(){
        return $this->belongsTo(Address::class, 'address_id','id');
    }
    
    //
    public function getItemCountAttribute(){
        return $this->items->count(); // this accessor will return the item_count for perticular order.
    }

    public function getOrderPlaceAtAttribute(){
        return Carbon::parse($this->created_at)->format('d M Y H:i A');
    }

    public function getOrderConfirmedAtAttribute(){
        if($this->confirmed_at){
            return Carbon::parse($this->confirmed_at)->format('d M Y H:i A');
        }
        else 
            return null;
    }

    public function getOrderDeliveredAtAttribute(){
        if($this->confirmed_at){
            return Carbon::parse($this->delivered_at)->format('d M Y H:i A');
        }
        else 
            return null;
    }

    public function getOrderCancelledAtAttribute(){
        if($this->confirmed_at){
            return Carbon::parse($this->cancelled_at)->format('d M Y H:i A');
        }
        else 
            return null;
    }
}
