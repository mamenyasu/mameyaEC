<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ご注文ありがとうございました</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-lg w-full bg-white shadow p-8 rounded text-center">

        <h1 class="text-2xl font-bold mb-4">ご注文ありがとうございました</h1>

        <p class="text-gray-700 mb-6">
            ご注文を受け付けました。<br>
            商品の発送準備が整い次第、メールにてご連絡いたします。
        </p>

        {{-- 注文番号 --}}
        @if(session('order_id'))
        <div class="bg-gray-50 border p-4 rounded mb-6">
            <p class="text-gray-600">注文番号</p>
            <p class="text-xl font-semibold">{{ session('order_id') }}</p>
        </div>
        @endif

        <a href="{{ route('home') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded inline-block">
            トップページへ戻る
        </a>

    </div>

</body>

</html>
