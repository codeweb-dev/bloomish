<div class="p-6 bg-zinc-100 dark:bg-zinc-900 rounded-lg flex flex-col justify-between">
    <div class="flex flex-col gap-3 mb-6">
        <div class="flex items-center gap-1 text-yellow-400">
            @for ($i = 0; $i < 5; $i++)
                <x-heroicon-s-star class="w-5 h-5" />
            @endfor
        </div>

        <h5 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title ?? 'Anonymous' }}</h5>
        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $review ?? 'This is a great product!' }}</p>
    </div>

    <div>
        <div class="pt-4">
            <h6 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $name ?? 'Anonymous' }}</h6>
            <p class="text-xs text-zinc-600 dark:text-zinc-400">{{ $position ?? 'CEO, Example Corp' }}</p>
        </div>
    </div>
</div>
