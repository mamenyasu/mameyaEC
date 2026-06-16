<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <p class="mx-auto my-4 p-3 w-[200px] bg-gray-100 text-red-700 rounded shadow font-bold text-center drop-shadow-sm">メンバー一覧</p>
    @foreach($members as $member)
    <div class="mx-auto my-4 p-3 w-[200px] container-md bg-gray-100 shadow texet-center drop-shadow-sm">
        <p>{{ $member->name }}</P>
        <p>{{ $member->age}}</p>
        <p>{{ $member->position }}</P>
        <p>{{ $member->playStyle}}</p>
    </div>
    @endforeach
    <div class="w-[400px] shadow mx-auto my-4">
        {{ $members->links() }}
    </div>
    <div>
        <a href="{{route('mainEC')}}">メインECへ</a>
    </div>

</body>


</html>