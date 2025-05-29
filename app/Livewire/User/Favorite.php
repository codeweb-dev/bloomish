<?php

namespace App\Livewire\User;

use App\Models\Cart;
use Livewire\Attributes\Title;
use App\Models\Favorite as FavoriteModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Shop')]
class Favorite extends Component
{
    public function removeFavorite($favoriteId)
    {
        $favorite = FavoriteModel::find($favoriteId);

        if ($favorite && $favorite->user_id === Auth::id()) {
            $favorite->delete();
            Toaster::success($favorite->product->name . ' removed successfully.');
        } else {
            Toaster::error('Favorite not found or you do not have permission to remove it.');
        }
    }

    public function cart($favoriteId)
    {
        $user = Auth::user();

        if (!$user) {
            Toaster::error('You must be logged in to manage your cart.');
            return;
        }

        $favorite = FavoriteModel::with('product')->find($favoriteId);

        if (!$favorite || $favorite->user_id !== $user->id) {
            Toaster::error('Favorite not found or unauthorized.');
            return;
        }

        $productId = $favorite->product_id;

        $existing = $user->carts()->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            Toaster::info($favorite->product->name . ' removed from cart.');
        } else {
            $user->carts()->create(['product_id' => $productId]);
            Toaster::success($favorite->product->name . ' added to cart.');
        }
    }

    public function render()
    {
        $favorites = FavoriteModel::with('product.category', 'product.brand')
            ->where('user_id', Auth::id())
            ->get();

        $carts = Cart::with('product.category', 'product.brand')
            ->where('user_id', Auth::id())
            ->get();

        return view('livewire.user.favorite', [
            'favorites' => $favorites,
            'carts' => $carts,
        ]);
    }
}
