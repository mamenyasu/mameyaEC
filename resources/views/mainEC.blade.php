<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '小規模ECサイト' }}</title>

    {{-- Tailwind CDN（使いたい場合） --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <!-- サイドバー -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-6">
            <h2 class="text-xl font-bold">メニュー</h2>

            <nav class="space-y-3">
                <a href="#" class="block text-gray-700 hover:text-blue-600">アカウント</a>
                <a href="{{route('cartIndex')}}" class="block text-gray-700 hover:text-blue-600">カート</a>
                <a href="#" class="block text-gray-700 hover:text-blue-600">注文履歴</a>
                <a href="{{route('mainEC')}}" class="block text-gray-700 hover:text-blue-600">商品一覧</a>
            </nav>
        </aside>

        <!-- メインエリア -->
        <main class="flex-1 p-8">

            <h1 class="text-2xl font-bold mb-6">商品一覧</h1>
            <!-- 商品グリッド -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow p-4">
                    <!-- 商品画像 -->
                    <img src="{{ $product->image_url }}"
                        alt="{{ $product->name }}"
                        class="w-full aspect-[3/2] object-cover rounded mb-3">

                    <!-- 商品名 -->
                    <h3 class="font-semibold">{{ $product->name }}</h3>

                    <!-- 価格 -->
                    <p class="text-gray-600 text-sm">¥{{ number_format($product->price) }}</p>

                    <!-- カートボタン -->
                    <button class="add-to-cart mt-3 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700" data-id="{{$product->id}}">
                        カートに入れる
                    </button>
                </div>
                @endforeach
            </div>
            <!-- ページネーション -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </main>

    </div>


    <script>
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', async () => {
    
                const id = btn.dataset.id;

                await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({id})
                });

            });
        });
    </script>


</body>

</html>