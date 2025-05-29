<div>
    <div class="relative">
        <img src="{{ $image ?? 'https://fakeimg.pl/300/' }}" class="w-full h-64 object-cover rounded-lg mb-4">

        <div class="absolute top-3 left-3 flex gap-2">
            <div class="text-xs rounded-lg px-3 py-1 dark:text-white text-black dark:bg-black bg-white w-max">{{ $brand
                ?? 'Product Brand' }}</div>
            <div class="text-xs rounded-lg px-3 py-1 dark:text-white text-black dark:bg-black bg-white w-max ">
                Bestseller</div>
        </div>

        <div class="absolute top-3 right-3 flex gap-2">
            <div class="text-xs rounded-full p-2 dark:text-white text-black dark:bg-black bg-white w-max">
                <x-heroicon-o-heart class="w-5 h-5" />
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-2">
        {{-- <div class="flex items-center gap-2">
            <div class="flex items-center gap-1 text-yellow-400">
                <x-heroicon-s-star class="w-5 h-5" />
                <x-heroicon-s-star class="w-5 h-5" />
                <x-heroicon-s-star class="w-5 h-5" />
                <x-heroicon-s-star class="w-5 h-5" />
                <x-heroicon-s-star class="w-5 h-5" />
            </div>
            <p class="text-sm font-bold">4.6 (100)</p>
        </div> --}}

        <div class="flex gap-3 flex-col">
            <h6 class="text font-semibold">{{ $title ?? 'Product Title' }}</h6>
            <p class="text-xs">{{ $author ?? 'Author Name' }}</p>

            <div class="flex items-center justify-between">
                <p class="text-sm font-bold">{{ $price ?? '₱999.99' }}</p>

                <button
                    class="dark:text-black text-white dark:bg-white bg-black rounded-full px-6 py-2 text-sm font-bold">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>
