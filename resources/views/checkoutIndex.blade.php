<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>カート</title>
</head>


<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <!-- サイドバー -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-6">
            <h2 class="text-xl font-bold">メニュー</h2>

            <nav class="space-y-3">
                <a href="#" class="block text-gray-700 hover:text-blue-600">アカウント</a>
                <a href="{{ route('cartIndex') }}" class="block text-gray-700 hover:text-blue-600">カート</a>
                <a href="#" class="block text-gray-700 hover:text-blue-600">注文履歴</a>
                <a href="{{route('mainEC')}}" class="block text-gray-700 hover:text-blue-600">商品一覧</a>
            </nav>
        </aside>

        <!-- メインエリア -->
        <main class="flex-1 p-8 ml-10">
            <div class="max-w-3xl mx-auto space-y-8">

                <h1 class="text-2xl font-bold mb-6">決済情報の入力</h1>

                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- ▼ ユーザー情報 -->
                    <div class="bg-white p-6 rounded-lg shadow space-y-4">
                        <h2 class="text-xl font-semibold mb-2">お客様情報</h2>

                        <div>
                            <label class="block text-gray-700">名前</label>
                            <input type="text" name="name"
                                value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                placeholder="山田 太郎"
                                class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-gray-700">住所</label>
                            <input type="text" name="address"
                                value="{{ auth()->check() ? auth()->user()->address : '' }}"
                                placeholder="東京都〇〇区〇〇 1-2-3"
                                class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-gray-700">電話番号</label>
                            <input type="text" name="phone"
                                value="{{ auth()->check() ? auth()->user()->phone : '' }}"
                                placeholder="090-1234-5678"
                                class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-gray-700">メールアドレス</label>
                            <input type="email" name="email"
                                value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                placeholder="example@example.com"
                                class="w-full border rounded p-2">
                        </div>
                    </div>

                    <!-- ▼ 決済方法 -->
                    <div class="bg-white p-6 rounded-lg shadow space-y-4">
                        <h2 class="text-xl font-semibold mb-2">決済方法</h2>

                        <label class="flex items-center space-x-2">
                            <input type="radio" name="payment" value="cod" checked>
                            <span>着払い</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="radio" name="payment" value="card">
                            <span>クレジットカード</span>
                        </label>

                        <!-- ▼ クレジットカード入力欄（初期はグレーアウト） -->
                        <div id="card-fields" class="opacity-50 pointer-events-none space-y-3 mt-4">

                            <div>
                                <label class="block text-gray-700">カード番号</label>
                                <input type="text" name="card_number"
                                    placeholder="1234 5678 9012 3456"
                                    class="w-full border rounded p-2">
                            </div>

                            <div>
                                <label class="block text-gray-700">有効期限</label>
                                <input type="text" name="card_exp"
                                    placeholder="12/34"
                                    class="w-full border rounded p-2">
                            </div>

                            <div>
                                <label class="block text-gray-700">セキュリティコード</label>
                                <input type="text" name="card_cvc"
                                    placeholder="123"
                                    class="w-full border rounded p-2">
                            </div>

                        </div>
                    </div>

                    <!-- ▼ 商品一覧（縦に一列で並ぶ） -->
                    <div class="bg-white p-6 rounded-lg shadow space-y-4">
                        <h2 class="text-xl font-semibold mb-2">購入商品</h2>

                        @foreach ($products as $product)
                        <div class="border-b pb-3">
                            <p class="font-semibold">{{ $product['name'] }}</p>
                            <p class="text-gray-600">数量：{{ $product['qty'] }}</p>
                            <p class="text-gray-600">小計：¥{{ number_format($product['price'] * $product['qty']) }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- ▼ ボタン -->
                    <div class="flex justify-between">
                        <a href="{{ route('cartIndex') }}"
                            class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                            前に戻る
                        </a>

                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            購入する
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <!-- ▼ 決済方法によるクレカ欄の切り替え -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cardFields = document.getElementById('card-fields');
            const radios = document.querySelectorAll('input[name="payment"]');

            radios.forEach(r => {
                r.addEventListener('change', () => {
                    if (r.value === 'card') {
                        cardFields.classList.remove('opacity-50', 'pointer-events-none');
                    } else {
                        cardFields.classList.add('opacity-50', 'pointer-events-none');
                    }
                });
            });
        });
    </script>
</body>