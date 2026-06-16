<x-layouts::app :title="__('ダッシュボード')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class="relative z-10 p-4">
                @can('test2')
                <p>現在のフォーメーション</p>
                @endcan
                <p>{{ "3-3-4" }}</p>
                <p>スターティングメンバー</p>
                <p>{{ "フォワード" }} {{ "中根 由量"  }}</p>
                <a href="{{ route('memberIndex') }}">メンバー一覧</a>
                </div>
                
             
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
    </div>
</x-layouts::app>
