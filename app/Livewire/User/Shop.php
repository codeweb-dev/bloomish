<?php

namespace App\Livewire\User;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

#[Title('Shop')]
class Shop extends Component
{
    public function favorite($productId)
    {
        $user = Auth::user();

        if (!$user) {
            Toaster::error('You must be logged in to favorite products.');
            return;
        }

        $product = Product::find($productId);

        if (!$product) {
            Toaster::error('Product does not exist.');
            return;
        }

        $existing = $user->favorites()->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            Toaster::info('Product removed from favorites.');
        } else {
            $user->favorites()->create(['product_id' => $productId]);
            Toaster::success('Product added to favorites.');
        }
    }

    public function cart($productId)
    {
        $user = Auth::user();

        if (!$user) {
            Toaster::error('You must be logged in to manage your cart.');
            return;
        }

        $existing = $user->carts()->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            Toaster::info('Product removed from cart.');
        } else {
            $user->carts()->create(['product_id' => $productId]);
            Toaster::success('Product added to cart.');
        }
    }

    public function render()
    {
        $products = Product::with('category', 'brand')->get();
        $favorites = Auth::check()
            ? Auth::user()->favorites()->pluck('product_id')->toArray()
            : [];
        $carts = Auth::check()
            ? Auth::user()->carts()->pluck('product_id')->toArray()
            : [];

        return view('livewire.user.shop', [
            'products' => $products,
            'favorites' => $favorites,
            'carts' => $carts,
        ]);
    }
}
