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
    <div class="flex m-h-screen">

        <!-- サイドバー -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-6">
            <h2 class="text-xl font-bold">メニュー</h2>

            <nav class="space-y-3">
                <a href="{{ auth()->check() ? route('profileEdit') : route('login') }}" class="block text-gray-700 hover:text-blue-600"> {{ auth()->check() ? 'アカウント' : 'ログイン' }}</a>
                <a href="{{route('cartIndex')}}" class="block text-gray-700 hover:text-blue-600">カート</a>
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

        {{-- 右メインエリア --}}
        <div class="flex-1 bg-white p-10">

            <h1 class="text-2xl font-bold mb-6">注文履歴</h1>

            {{-- 注文がない場合 --}}
            @if($orders->isEmpty())
            <p class="text-gray-600">まだ注文はありません。</p>
            @else

            <div class="space-y-6">

                @foreach($orders as $order)
                <div class="border rounded p-4 shadow-sm">

                    <div class="flex justify-between mb-2">
                        <div>
                            <p class="font-semibold">注文番号：{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">注文日：{{ $order->created_at->format('Y-m-d') }}</p>
                        </div>
                        <p class="font-bold text-lg">¥{{ number_format($order->total) }}</p>
                    </div>

                    <div class="mt-3">
                        <p class="text-sm text-gray-700 font-semibold mb-1">注文商品：</p>

                        <ul class="list-disc ml-5 text-sm text-gray-700">
                            @foreach($order->items as $item)
                            <li>{{ $item->product->name }} × {{ $item->qty }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                @endforeach

            </div>

            @endif

        </div>
    </div>

</body>

</html>