<?php

namespace App\Http\Controllers;

use App\Dto\MemberDto;
use App\Models\Product;
use App\Services\MemberDto_buildService;
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

            session()->put('cart', $cart);

            return response()->noContent();
        }
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

    /**
     * 決済処理
     */
    public function checkoutProcess(Request $request)
    {
        // ▼ バリデーション（必要最低限）
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'required|email',
            'payment'     => 'required|in:cod,card',
            'card_number' => 'nullable|string',
            'card_exp'    => 'nullable|string',
            'card_cvc'    => 'nullable|string',
        ]);

        // ▼ カード決済の場合のみカード情報必須
        if ($validated['payment'] === 'card') {
            $request->validate([
                'card_number' => 'required|string',
                'card_exp'    => 'required|string',
                'card_cvc'    => 'required|string',
            ]);
        }

        // ▼ カート取得
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cartIndex')->with('error', 'カートが空です');
        }

        // ▼ 注文データ保存（ここは後で OrderService に切り出してもOK）
        // 今は簡易的にログに出すだけ
        /*\Log::info('注文データ', [
            'user'     => Auth::user(),
            'customer' => $validated,
            'cart'     => $cart,
        ]);*/

        // ▼ カートを空にする
        Session::forget('cart');

        // ▼ 完了ページへ
        return redirect()->route('checkout.complete');
    }
}
