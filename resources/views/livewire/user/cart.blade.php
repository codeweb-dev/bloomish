<div class="relative mb-6 w-full max-w-6xl mx-auto">
    <flux:heading size="xl" level="1">{{ __('Cart') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ $cartCount }} {{ Str::plural('item', $cartCount) }} in your cart
    </flux:subheading>
    <flux:separator variant="subtle" />

    @if($carts->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-500 mb-4">{{ __('You have no cart products yet.') }}</p>
        <a href="{{ route('shop') }}" wire:navigate>
            <flux:button variant="primary" icon="plus">{{ __('Browse Products') }}</flux:button>
        </a>
    </div>
    @else
    <div class="flex w-full gap-6 my-6">
        <div class="flex-1 flex flex-col gap-6 p-6 rounded-lg border dark:border-white/20 border-black/20">
            @foreach ($carts as $cart)
            <div class="flex items-center gap-6">
                <img src="{{ $cart->product->image_url }}" alt="" class="w-24 h-24 object-cover rounded-lg">

                <div class="flex justify-between w-full">
                    <div class="flex flex-col justify-between">
                        <div>
                            <flux:badge size="sm" variant="solid" color="zinc">{{ $cart->product->stock }} Stock
                            </flux:badge>
                        </div>

                        <h2>{{ $cart->product->name }}</h2>

                        <p class="text-sm text-gray-500">PHP{{ $cart->product->price }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:button.group>
                            <flux:button icon="minus" wire:click="decrement({{ $cart->id }})"></flux:button>
                            <flux:button>{{ $cart->quantity }}</flux:button>
                            <flux:button icon="plus" wire:click="increment({{ $cart->id }})"></flux:button>
                        </flux:button.group>

                        <flux:button icon="trash" variant="danger" wire:click="removeCart({{ $cart->id }})" />
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-6 p-6 rounded-lg w-[400px] border dark:border-white/20 border-black/20">
            <flux:subheading size="lg">{{ __('Order Summary') }}</flux:subheading>
            <flux:separator variant="subtle" />

            <div class="flex justify-between items-center">
                <span class="text-sm">{{ __('Subtotal') }}</span>
                <span class="text-sm">PHP{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm">{{ __('Shipping') }}</span>
                <span class="text-sm">PHP49.00</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-bold">{{ __('Total') }}</span>
                <span class="text-sm font-bold">
                    PHP{{ number_format($subtotal + 49, 2) }}
                </span>
            </div>

            @if ($this->hasAddress)
            <div class="flex flex-col gap-3">
                <div class="p-4 rounded-lg border dark:border-white/20 border-black/20">
                    <div class="text-sm">
                        <p class="font-bold">Shipping Address:</p>
                        <p>{{ auth()->user()->street_address }}, {{ auth()->user()->brgy }}</p>
                        <p>{{ auth()->user()->city }}, {{ auth()->user()->province }}</p>
                        <p>{{ auth()->user()->region }}, {{ auth()->user()->postal_code }}</p>
                    </div>
                </div>

                <flux:button href="{{ route('settings.address') }}" icon="map-pin" class="w-full" wire:navigate>
                    Change address
                </flux:button>
            </div>
            @else
            <flux:button href="{{ route('settings.address') }}" icon="map-pin" class="w-full" wire:navigate>
                Add address
            </flux:button>
            @endif

            <flux:radio.group wire:model="payment" label="Select your payment method">
                <flux:radio value="cod" label="Cash On Delivery" checked />
            </flux:radio.group>

            <flux:modal.trigger name="confirm-checkout">
                <flux:button icon="shopping-cart" variant="primary" class="w-full">Checkout</flux:button>
            </flux:modal.trigger>

            <flux:modal name="confirm-checkout" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Confirm Checkout</flux:heading>
                        <flux:text class="mt-2">
                            Are you sure you want to place this order totaling
                            <strong class="text-yellow-500">PHP{{ number_format($subtotal + 49, 2) }}</strong>?
                        </flux:text>
                    </div>

                    <div class="flex">
                        <flux:spacer />

                        <flux:button type="submit" variant="primary">Confirm</flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
    </div>
    @endif
</div>
