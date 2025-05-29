<x-layouts.app.header :title="$title ?? null">
    <flux:main>
        {{ $slot }}

        @include('partials.welcome.footer')
    </flux:main>
</x-layouts.app.header>
