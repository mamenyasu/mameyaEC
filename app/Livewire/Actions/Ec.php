<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Ec extends Component
{
    use WithPagination;

    public array $items = [];

    public function addToCart($productId)
    {
        $cart = session('cart', []);
        $cart[$productId]['qty'] = ($cart[$productId]['qty'] ?? 0) + 1;
        session()->put('cart', $cart);
        $this->items = $cart;
    }

    public function render()
    {
        return view('livewire.main-e-c');
    }
}
