<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            // 購入者情報
            $table->string('name');
            $table->string('address');
            $table->string('tel');
            $table->string('email');

            // 決済情報
            $table->string('payment_method'); // credit / cod
            $table->string('card_last4')->nullable();
            $table->string('card_exp')->nullable();
            $table->string('card_name')->nullable();

            // 金額
            $table->integer('subtotal');
            $table->integer('shipping_fee')->default(0);
            $table->integer('total');

            // 発送ステータス
            $table->string('status')->default('pending');
            // pending（未発送） / shipped（発送済） / canceled（キャンセル）

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
