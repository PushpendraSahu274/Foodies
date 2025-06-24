<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $guarded = [];

    protected $with = ['item'];
    protected $appends = [
        'total_amount',
        'item_price',
        'item_total_discount'
    ];

    public function item()
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); //cart belongs to customer.
    }

    public function getTotalAmountAttribute()
    {

        $meal = $this->item; //fetched the cart item
        if (!$meal) return 0;
        $discountPercentage = $meal->discount_percentage ?? 0;
        $price = $meal->mrp - (($meal->mrp * $discountPercentage) / 100);

        return round($this->quantity * $price,2);
    }

    public function getItemPriceAttribute()
    {
        $meal = $this->item;
        if (!$meal) return 0;

        $discountPercentage = $meal->discount_percentage ?? 0;
        $price = $meal->mrp - (($meal->mrp * $discountPercentage) / 100);

        return round($price, 2);
    }


    public function getItemTotalDiscountAttribute()
    {
        $meal = $this->item;
        if (!$meal) return 0;
        $discount = $meal->discount_percentage ? $meal->discount_percentage : 0;
        $discountPerItem = ($meal->mrp * $discount) / 100;
        $total_discount =  $this->quantity * $discountPerItem;

        return round($total_discount, 2);
    }
}
