<?php

// Admin
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Brands;
use App\Livewire\Admin\Users;

// User
use App\Livewire\User\Receipt;
use App\Livewire\User\Favorite;
use App\Livewire\User\Search;
use App\Livewire\User\Shop;
use App\Livewire\User\Cart;

use Illuminate\Support\Facades\Route;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Address;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group(['middleware' => ['role:user|admin']], function () {
    Route::get('/receipt/{orderIds}', Receipt::class)->middleware(['auth', 'verified'])->name('receipt');
    Route::get('/favorite', Favorite::class)->middleware(['auth', 'verified'])->name('favorite');
    Route::get('/search', Search::class)->middleware(['auth', 'verified'])->name('search');
    Route::get('/shop', Shop::class)->middleware(['auth', 'verified'])->name('shop');
    Route::get('/cart', Cart::class)->middleware(['auth', 'verified'])->name('cart');

    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
        Route::get('settings/profile', Profile::class)->name('settings.profile');
        Route::get('settings/address', Address::class)->name('settings.address');
        Route::get('settings/password', Password::class)->name('settings.password');
    });
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/categories', Categories::class)->middleware(['auth', 'verified'])->name('categories');
    Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/products', Products::class)->middleware(['auth', 'verified'])->name('products');
    Route::get('/orders', Orders::class)->middleware(['auth', 'verified'])->name('orders');
    Route::get('/brands', Brands::class)->middleware(['auth', 'verified'])->name('brands');
    Route::get('/users', Users::class)->middleware(['auth', 'verified'])->name('users');
});

require __DIR__ . '/auth.php';
