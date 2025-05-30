<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Cart as CartModel;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

#[Title('Cart')]
class Cart extends Component
{
    public $payment = 'cod';
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function removeCart($cartId)
    {
        $cart = CartModel::find($cartId);

        if ($cart && $cart->user_id === Auth::id()) {
            $cart->delete();
            session()->flash('success', 'Item removed from cart successfully.');
            Toaster::success('Item removed from cart successfully.');
        } else {
            Toaster::error('Cart item not found or you do not have permission to remove it.');
        }
    }

    public function getCartData()
    {
        return CartModel::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function getHasAddressProperty()
    {
        $user = Auth::user();

        return $user->region && $user->province && $user->city && $user->brgy && $user->street_address;
    }

    public function checkout()
    {
        if (!$this->getHasAddressProperty()) {
            Flux::modal('confirm-checkout')->close();
            Toaster::error('Please complete your address before checking out.');
            return;
        }

        $carts = $this->getCartData();

        if ($carts->isEmpty()) {
            Flux::modal('confirm-checkout')->close();
            Toaster::error('Your cart is empty.');
            return;
        }

        $orderIds = [];
        foreach ($carts as $cart) {
            $product = $cart->product;

            if ($product->stock < $cart->quantity) {
                Flux::modal('confirm-checkout')->close();
                Toaster::error("Product {$product->name} does not have enough stock.");
                return;
            }

            $product->decrement('stock', $cart->quantity);

            $order = $product->orders()->create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total_price' => $product->price * $cart->quantity,
                'quantity' => $cart->quantity,
                'shipping_address' => Auth::user()->getFullAddress(),
                'shipping_method' => $this->payment,
            ]);

            $orderIds[] = $order->id;

            $cart->delete();
        }

        Flux::modal('confirm-checkout')->close();
        return redirect()->route('receipt', ['orderIds' => implode(',', $orderIds)]);
    }

    public function increment($cartId)
    {
        $cart = CartModel::with('product')->find($cartId);

        if ($cart && $cart->user_id === Auth::id()) {
            if ($cart->quantity >= $cart->product->stock) {
                Toaster::error('Cannot increment. Only ' . $cart->product->stock . ' in stock.');
                return;
            }

            $cart->increment('quantity');
        } else {
            Toaster::error('Cart item not found or unauthorized access.');
        }
    }

    public function decrement($cartId)
    {
        $cart = CartModel::find($cartId);
        if ($cart && $cart->user_id === Auth::id() && $cart->quantity > 1) {
            $cart->decrement('quantity');
        }
    }

    public function render()
    {
        $carts = $this->getCartData();

        $subtotal = $carts->sum(fn($cart) => $cart->product->price * $cart->quantity);

        return view('livewire.user.cart', [
            'carts' => $carts,
            'subtotal' => $subtotal,
            'cartCount' => $carts->count(),
        ]);
    }
}
