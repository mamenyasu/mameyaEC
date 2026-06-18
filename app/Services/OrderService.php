<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrderService
{
    public function createOrder(array $data, array $cartItems)
    {
        return DB::transaction(function () use ($data, $cartItems) {

            // ① 注文（orders）を作成
            $order = Order::create([
                'name'           => $data['name'],
                'address'        => $data['address'],
                'tel'            => $data['tel'],
                'email'          => $data['email'],
                'payment_method' => $data['payment_method'],
                'card_last4'     => $data['payment_method'] === 'credit'
                    ? substr($data['card_number'], -4)
                    : null,
                'card_exp'       => $data['card_exp'] ?? null,
                'card_name'      => $data['card_name'] ?? null,
                'subtotal'       => $data['subtotal'],
                'shipping_fee'   => 0,
                'total'          => $data['subtotal'],
                'status'         => 'pending',
                'user_id'        => Auth::id(),
            ]);

            // ② 注文商品（order_items）を作成
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['id'],
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'qty'          => $item['qty'],
                ]);
            }

            return $order;
        });
    }
}
