<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem; 

class Order extends Model
{
    protected $fillable = [
        'name',
        'address',
        'tel',
        'email',
        'payment_method',
        'card_last4',
        'card_exp',
        'card_name',
        'subtotal',
        'shipping_fee',
        'total',
        'status',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
