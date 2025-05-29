<div class="w-full max-w-6xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
        <div>
            <div class="relative group">
                <img src="{{ $product->image_url }}" class="w-full h-64 object-cover rounded-lg mb-4">

                <div class="absolute top-3 left-3 flex gap-2">
                    <flux:badge variant="solid" icon="adjustments-horizontal" size="sm">{{
                        $product->brand->name }}</flux:badge>
                    <flux:badge variant="solid" icon="adjustments-horizontal" size="sm">Bestseller</flux:badge>
                </div>

                <div class="absolute top-3 right-3">
                    <div class="flex items-center gap-1">
                        <flux:tooltip
                            content="{{ in_array($product->id, $favorites) ? 'Favorited' : 'Add to Favorites' }}">
                            <flux:button wire:click="favorite({{ $product->id }})"
                                :variant="in_array($product->id, $favorites) ? 'primary' : 'primary'"
                                :icon="in_array($product->id, $favorites) ? 'heart' : 'heart'" size="sm"
                                :class="in_array($product->id, $favorites) ? 'text-green-500' : ''" />
                        </flux:tooltip>

                        <flux:tooltip content="{{ in_array($product->id, $carts) ? 'Added to Cart' : 'Add to Cart' }}">
                            <flux:button wire:click="cart({{ $product->id }})"
                                :variant="in_array($product->id, $carts) ? 'primary' : 'primary'"
                                :icon="in_array($product->id, $carts) ? 'check' : 'shopping-cart'" size="sm" />
                        </flux:tooltip>
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
                    <h6 class="text font-semibold">{{ $product->name }}</h6>
                    <p class="text-xs">{{ $product->description }}</p>

                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold">PHP{{ $product->price }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
