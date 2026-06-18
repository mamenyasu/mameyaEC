<?php

namespace App\Http\Controllers;

use App\Dto\MemberDto;
use App\Http\Requests\CheckoutConfirmRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\MemberDto_buildService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MemberIndexController extends Controller
{
    public function membersIndex(MemberDto_buildService $dtoBuilder)
    {

        Gate::authorize('test');

        $dto = new MemberDto();
        $dto = $dtoBuilder->build($dto);
        return view('membersIndex', $dto->toViewData());
    }

    public function mainEC()
    {
        $products = Product::paginate(12);
        return view('mainEC', compact('products'));
    }

    public function add(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);

        $cart = session('cart', []);
        if (isset($cart[$id])) {
            // 数量だけ増やす
            $cart[$id]['qty'] += 1;
        } else {
            // 商品情報を丸ごと保存
            $cart[$id] = [
                'id'        => $product->id,
                'name'      => $product->name,
                'price'     => $product->price,
                'image_url' => $product->image_url,
                'qty'       => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->noContent();
    }



    public function cartIndex()
    {
        $cart = session('cart', []);

        // 商品ID一覧を取得
        $ids = array_keys($cart);

        // 商品情報をまとめて取得
        $products = \App\Models\Product::whereIn('id', $ids)->get();

        // 数量を紐づける
        foreach ($products as $p) {
            $p->qty = $cart[$p->id]['qty'];
        }

        return view('cartIndex', compact('products'));
    }

    public function cartRemove(Request $request)
    {
        $id = $request->id;

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->noContent();
    }



    /* 決済ページ表示
     */
    public function checkoutIndex()
    {
        // セッションからカート取得
        $products = Session::get('cart', []);

        return view('checkoutIndex', [
            'products' => $products,
        ]);
    }



    public function checkoutConfirm(CheckoutConfirmRequest $request)
    {
        // バリデーション済みデータ
        $validated = $request->validated();

        // セッションからカートを取得（商品情報が丸ごと入っている）
        $cart = session('cart', []);

        // カートが空なら戻す
        if (empty($cart)) {
            return redirect()->route('cartIndex')
                ->with('error', 'カートが空です。');
        }

        // 配列のまま Blade に渡す
        $cartItems = collect($cart);

        return view('checkoutConfirm', [
            'data' => $validated,
            'cartItems' => $cartItems,
        ]);
    }


    public function complete(Request $request, OrderService $orderService)
    {
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'カートが空です');
        }

        $order = $orderService->createOrder($request->all(), $cartItems);

        session()->flash('order_id', $order->id);
        session()->forget('cart');

        return redirect()->route('checkoutThanks');
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        // バリデーション
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $user->id,
            'tel'     => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        // 更新処理
        $user->update($validated);

        // 完了後はプロフィール編集画面に戻す
        return redirect()
            ->route('profileEdit')
            ->with('success', 'プロフィールを更新しました');
    }

    public function ordersIndex()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders', compact('orders'));
    }
}
