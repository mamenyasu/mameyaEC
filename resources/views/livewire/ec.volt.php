<?php

use App\Models\Product;

$products = Product::paginate(12);

?>

<div>
    <div class="grid grid-cols-4 gap-4">
        @foreach ($products as $product)
            <div class="p-4 bg-white shadow">
                <p>{{ $product->name }}</p>
                <button wire:click="addToCart({{ $product->id }})"
                    class="bg-blue-500 text-white px-3 py-1 rounded">
                    カートに入れる
                </button>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
