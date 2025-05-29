<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Cart as CartModel;
use Masmerise\Toaster\Toaster;

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
