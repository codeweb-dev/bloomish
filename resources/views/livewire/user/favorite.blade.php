<div class="relative mb-6 w-full max-w-6xl mx-auto">
    <flux:heading size="xl" level="1">{{ __('Favorite') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your favorite products') }}</flux:subheading>
    <flux:separator variant="subtle" />

    @if($favorites->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-500 mb-4">{{ __('You have no favorite products yet.') }}</p>
        <a href="{{ route('shop') }}" wire:navigate>
            <flux:button variant="primary" icon="plus">{{ __('Browse Products') }}</flux:button>
        </a>
    </div>
    @else
    <x-user-components.table :headers="['Product', 'Description', 'Brand', 'Category', '']">
        @foreach ($favorites as $favorite)
        <tr class="hover:bg-white/5 bg-black/5 transition-all">
            <td class="px-3 py-4 flex items-center gap-2">
                <flux:avatar src="{{ $favorite->product->image_url }}" />
                <div class="flex flex-col">
                    <span class="font-bold">{{ $favorite->product->name }}</span>
                    <span>PHP{{ number_format($favorite->product->price, 2) }}</span>
                </div>
            </td>
            <td class="px-3 py-4">{{ $favorite->product->description }}</td>
            <td class="px-3 py-4">
                <flux:badge size="sm" icon="check-badge">{{ $favorite->product->brand->name }}</flux:badge>
            </td>
            <td class="px-3 py-4">
                <flux:badge size="sm" icon="adjustments-horizontal">{{ $favorite->product->category->name }}
                </flux:badge>
            </td>
            <td class="px-3 py-4 flex gap-2">
                <flux:button size="xs" icon="trash" wire:click="removeFavorite({{ $favorite->id }})"
                    wire:loading.attr="disabled">
                    {{ __('Remove') }}
                </flux:button>

                @php
                $productId = $favorite->product_id;
                $inCart = $carts->pluck('product_id')->contains($productId);
                @endphp

                <flux:button wire:click="cart({{ $favorite->id }})" :variant="$inCart ? 'primary' : 'primary'"
                    icon="{{ $inCart ? 'check' : 'shopping-cart' }}" size="xs">
                    {{ $inCart ? 'Added to cart' : 'Add to cart' }}
                </flux:button>
            </td>
        </tr>
        @endforeach
    </x-user-components.table>
    @endif
</div>
