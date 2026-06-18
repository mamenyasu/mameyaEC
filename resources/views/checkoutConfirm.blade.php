<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>最終確認</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 ">
    <div class="flex min-h-screen">

        <!-- サイドバー -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-6">
            <h2 class="text-xl font-bold">メニュー</h2>

            <nav class="space-y-3">
                <a href="{{ auth()->check() ? route('profileEdit') : route('login') }}" class="block text-gray-700 hover:text-blue-600"> {{ auth()->check() ? 'アカウント' : 'ログイン' }}</a>
                <a href="{{ route('cartIndex') }}" class="block text-gray-700 hover:text-blue-600">カート</a>
                <a href="{{route('ordersIndex')}}" class="block text-gray-700 hover:text-blue-600">注文履歴</a>
                <a href="{{route('mainEC')}}" class="block text-gray-700 hover:text-blue-600">商品一覧</a>
            </nav>
            <div x-data="{ open: false }" class="mt-10">
                <!-- 表示部分 -->
                <button
                    @click="open = !open"
                    class="w-full text-left bg-gray-100 p-4 rounded shadow hover:bg-gray-200">
                    <p class="text-sm text-gray-600">
                        ようこそ
                        <span class="font-bold">
                            {{ auth()->check() ? auth()->user()->name . ' さん' : 'ゲストさん' }}
                        </span>
                    </p>
                </button>
            </div>
        </aside>


        <div class="max-w-2xl mx-auto py-6 px-40 my-auto bg-white shadow mt-10 rounded text-center">

            <h1 class="text-2xl font-bold mb-6">最終確認</h1>

            {{-- 購入者情報 --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">お客様情報</h2>
                <div class="space-y-1">
                    <p>名前：{{ $data['name'] }}</p>
                    <p>住所：{{ $data['address'] }}</p>
                    <p>電話番号：{{ $data['tel'] }}</p>
                    <p>メールアドレス：{{ $data['email'] }}</p>
                </div>
            </div>

            {{-- 決済方法 --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">決済方法</h2>
                <p>{{ $data['payment_method'] === 'credit' ? 'クレジットカード' : '代金引換' }}</p>

                @if($data['payment_method'] === 'credit')
                <div class="mt-2 pl-4 border-l">
                    <p>カード番号：**** **** **** {{ substr($data['card_number'], -4) }}</p>
                    <p>有効期限：{{ $data['card_exp'] }}</p>
                    <p>名義：{{ $data['card_name'] }}</p>
                </div>
                @endif
            </div>

            {{-- 商品一覧 --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">購入商品</h2>

                @foreach($cartItems as $item)
                <div class="border p-3 mb-3 rounded item-card" data-price="{{ $item['price'] }}" data-qty="{{ $item['qty'] }}">
                    <p class="font-semibold">{{ $item['name'] }}</p>
                    <p>価格：¥{{ number_format($item['price']) }}</p>
                    <p>数量：{{ $item['qty'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- ボタン --}}
            <form action="{{ route('checkoutComplete') }}" method="POST">
                @csrf

                {{-- hiddenで全データを送る --}}
                @foreach($data as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                {{-- 小計を表示 --}}
                <div id="subtotal" class="text-xl font-bold mt-4"></div>
                <input type="hidden" name="subtotal" id="subtotal_input">


                <div class="flex justify-between mt-6">
                    <a href="{{ route('checkout') }}"
                        class="px-4 py-2 bg-gray-300 rounded block text-center">
                        前に戻る
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                        購入する
                    </button>
                </div>
            </form>

        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                let subtotal = 0;

                // 商品カードを全部取得
                document.querySelectorAll('.item-card').forEach(card => {
                    const price = parseInt(card.dataset.price);
                    const qty = parseInt(card.dataset.qty);

                    subtotal += price * qty;
                });

                // 小計を表示
                document.getElementById('subtotal').textContent =
                    "小計：¥" + subtotal.toLocaleString();

                // 小計をhidden にセット
                document.getElementById('subtotal_input').value = subtotal;
            });
        </script>

    </div>
</body>

</html>