<header
    class="lg:w-full w-[95%] max-w-6xl text-sm mx-auto fixed top-3 left-0 right-0 flex items-center justify-between py-2 px-6 rounded-full dark:bg-white/10 bg-black/5 backdrop-blur-md z-50 ">
    <div class="flex items-center gap-1">
        <flux:modal.trigger name="menu" class="lg:hidden">
            <flux:button icon="ellipsis-vertical" variant="ghost" />
        </flux:modal.trigger>
        <flux:modal name="menu" variant="flyout">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Menu</flux:heading>
                    <flux:text class="mt-2">Quick access to the main sections of the site.</flux:text>
                </div>

                <flux:separator />

                <ul class="dark:text-white text-black flex flex-col gap-8">
                    <li><a href="#home" class="hover:underline">Home</a></li>
                    <li><a href="#about" class="hover:underline">About</a></li>
                    <li><a href="#products" class="hover:underline">Products</a></li>
                    <li><a href="#reviews" class="hover:underline">Reviews</a></li>
                </ul>
            </div>
        </flux:modal>

        <a href="#home" class="text-xl font-bold dark:text-white text-black">Bloomish</a>
    </div>

    <div class="ml-12 hidden lg:flex">
        <ul class="dark:text-white text-black flex items-center gap-8">
            <li><a href="#home" class="hover:underline">Home</a></li>
            <li><a href="#about" class="hover:underline">About</a></li>
            <li><a href="#products" class="hover:underline">Products</a></li>
            <li><a href="#reviews" class="hover:underline">Reviews</a></li>
        </ul>
    </div>

    <div class="flex items-center gap-3 text-white">
        <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
            aria-label="Toggle dark mode" />

        <flux:separator vertical class="my-2" />

        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            @role('admin')
            <a href="{{ url('/dashboard') }}" class="text-black bg-white rounded-full px-6 py-2">
                Admin Dashboard
            </a>
            @else
            <a href="{{ url('/shop') }}" class="text-black bg-white rounded-full px-6 py-2">
                Order Now
            </a>
            @endrole
            @else
            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="dark:text-black text-white dark:bg-white bg-black rounded-full px-6 py-2">
                Shop Now
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </div>
</header>
