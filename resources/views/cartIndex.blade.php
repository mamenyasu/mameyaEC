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
        <main class="flex-1 p-8">

            <div class="flex items-center mb-6">
                <h1 class="text-2xl font-bold">カート</h1>

                <a id="checkout-btn"
                    href="{{ route('checkout') }}"
                    class="px-4 py-2 rounded text-white bg-blue-600 hover:bg-blue-700 ml-4">
                    購入へ進む
                </a>
            </div>

            <!-- カート商品カードグリッド -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                @foreach ($products as $product)
                <div id="row-{{ $product->id }}" class="bg-white rounded-lg shadow p-4">

                    <!-- 商品画像 -->
                    <img src="{{ $product->image_url }}"
                        alt="{{ $product->name }}"
                        class="w-full aspect-[3/2] object-cover rounded mb-3">

                    <!-- 商品名 -->
                    <h3 class="font-semibold text-lg">{{ $product->name }}</h3>

                    <!-- 数量 -->
                    <p class="text-gray-700 mt-1">数量：{{ $product->qty }}</p>

                    <!-- 小計 -->
                    <p class="text-gray-600 text-sm mb-3">
                        小計：¥{{ number_format($product->price * $product->qty) }}
                    </p>

                    <!-- 削除ボタン -->
                    <button class="remove-btn w-full bg-red-600 text-white py-2 rounded hover:bg-red-700"
                        data-id="{{ $product->id }}">
                        削除
                    </button>
                </div>
                @endforeach

            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const updateCheckoutButton = () => {
                const itemCount = document.querySelectorAll('[id^="row-"]').length;
                const btn = document.getElementById('checkout-btn');

                if (itemCount === 0) {
                    btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    btn.classList.add('bg-gray-400', 'opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                } else {
                    btn.classList.remove('bg-gray-400', 'opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                    btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }
            };

            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;

                    await fetch('/cart/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            id
                        })
                    });

                    document.getElementById('row-' + id).remove();

                    // ← 削除後に購入ボタンの状態を更新
                    updateCheckoutButton();
                });
            });

            // 初期表示時にもチェック
            updateCheckoutButton();
        });
    </script>

</body>