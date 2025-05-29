<div>
    <div class="flex items-center gap-6">
        {{ $slot }}

        <div>
            <h5 class="text-lg font-bold">{{ $title ?? 'Title' }}</h5>
            <p class="text-sm">{{ $description ?? 'Description' }}</p>
        </div>
    </div>
</div>
