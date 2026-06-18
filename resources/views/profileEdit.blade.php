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
                <a href="{{ auth()->check() ? route('profileEdit') : route('login') }}" class="block text-gray-700 hover:text-blue-600">アカウント</a>
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

                <!-- ドロップダウンメニュー -->
                <div
                    x-show="open"
                    x-transition
                    class="mt-2 bg-white border rounded shadow p-3 space-y-2">
                    @if(auth()->check())
                    <a href="{{ route('profileEdit') }}" class="block text-gray-700 hover:text-blue-600">
                        プロフィール編集
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-red-600">
                            ログアウト
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-blue-600">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}" class="block text-gray-700 hover:text-blue-600">
                        新規登録
                    </a>
                    @endif
                </div>
            </div>
        </aside>




        {{-- 右メインエリア --}}
        <div class="flex-1 bg-white p-10 text-center">

            <h1 class="text-2xl font-bold mb-6">プロフィール編集</h1>
            @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif


            {{-- プロフィール更新フォーム --}}
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <form method="POST" action="{{ route('profileUpdate') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium">名前</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">メールアドレス</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">電話番号</label>
                            <input type="text" name="tel" value="{{ old('tel', auth()->user()->tel) }}"
                                class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">住所</label>
                            <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}"
                                class="w-full border rounded p-2">
                        </div>

                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            保存する
                        </button>
                    </form>
                </div>
            </div>

            <hr class="my-10">

            {{-- ログアウト --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    ログアウト
                </button>
            </form>

        </div>


</body>

</html>