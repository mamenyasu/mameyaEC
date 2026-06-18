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

        <!-- メインエリア -->
        <main class="flex-1 p-8 ml-10">
            <div class="max-w-3xl mx-auto space-y-8">

                <h1 class="text-2xl font-bold mb-6">決済情報の入力</h1>

                <form action="{{ route('checkoutConfirm') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="bg-white p-6 rounded-lg shadow space-y-4">
                        <h2 class="text-xl font-semibold mb-2">お客様情報</h2>

                        {{-- 名前 --}}
                        <div>
                            <label class="block text-gray-700">名前</label>
                            <input type="text" name="name"
                                value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}"
                                placeholder="山田 太郎"
                                class="w-full border rounded p-2">

                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 住所 --}}
                        <div>
                            <label class="block text-gray-700">住所</label>
                            <input type="text" name="address"
                                value="{{ old('address', auth()->check() ? auth()->user()->address : '') }}"
                                placeholder="東京都〇〇区〇〇 1-2-3"
                                class="w-full border rounded p-2">

                            @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 電話番号 --}}
                        <div>
                            <label class="block text-gray-700">電話番号</label>
                            <input type="text" name="tel"
                                value="{{ old('tel', auth()->check() ? auth()->user()->tel : '') }}"
                                placeholder="09012345678"
                                class="w-full border rounded p-2">

                            @error('tel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- メール --}}
                        <div>
                            <label class="block text-gray-700">メールアドレス</label>
                            <input type="email" name="email"
                                value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}"
                                placeholder="example@example.com"
                                class="w-full border rounded p-2">

                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow space-y-4">
                        <h2 class="text-xl font-semibold mb-2">決済方法</h2>

                        {{-- name を payment_method に修正 --}}
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="payment_method" value="cod"
                                {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                            <span>代金引換</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="radio" name="payment_method" value="credit"
                                {{ old('payment_method') === 'credit' ? 'checked' : '' }}>
                            <span>クレジットカード</span>
                        </label>

                        @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- ▼ クレジットカード入力欄 --}}
                        <div id="card-fields" class="space-y-3 mt-4 opacity-50 pointer-events-none">

                            <div>
                                <label class="block text-gray-700">カード番号</label>
                                <input type="text" name="card_number"
                                    value="{{ old('card_number') }}"
                                    placeholder="1234567890123456"
                                    class="w-full border rounded p-2">
                            </div>
                            @error('card_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div>
                                <label class="block text-gray-700">有効期限</label>
                                <input type="text" name="card_exp"
                                    value="{{ old('card_exp') }}"
                                    placeholder="12/34"
                                    class="w-full border rounded p-2">
                            </div>
                            @error('card_exp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div>
                                <label class="block text-gray-700">名義（カード名義）</label>
                                <input type="text" name="card_name"
                                    value="{{ old('card_name') }}"
                                    placeholder="TARO YAMADA"
                                    class="w-full border rounded p-2">
                            </div>
                            @error('card_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div>
                                <label class="block text-gray-700">セキュリティコード</label>
                                <input type="text" name="card_cvc"
                                    value="{{ old('card_cvc') }}"
                                    placeholder="123"
                                    class="w-full border rounded p-2">

                                @error('card_cvc')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
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
                            最終確認画面へ
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
            const radios = document.querySelectorAll('input[name="payment_method"]');

            const toggleCardFields = () => {
                const selected = document.querySelector('input[name="payment_method"]:checked');

                if (selected && selected.value === 'credit') {
                    cardFields.classList.remove('opacity-50', 'pointer-events-none');
                    cardFields.querySelectorAll('input').forEach(i => i.disabled = false);
                } else {
                    cardFields.classList.add('opacity-50', 'pointer-events-none');
                    cardFields.querySelectorAll('input').forEach(i => i.disabled = true);
                }
            };

            toggleCardFields();

            radios.forEach(r => {
                r.addEventListener('change', toggleCardFields);
            });
        });
    </script>



</body>