<?php

namespace App\Observers\Order;

use App\Models\Order;

class OrderObserver
{
    //
    public function updating(Order $order)
    {
        if ($order->isDirty('status')) {
            switch ($order->status) {
                case 'confirmed':
                    $order->confirmed_at = now();
                    break;
                case 'delivered':
                    $order->delivered_at = now();
                    break;
                case 'cancelled':
                    $order->cancelled_at = now();
                    break;
            }
        }
    }
}
