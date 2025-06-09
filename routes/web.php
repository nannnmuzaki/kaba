<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'store.index')->name('home');
Volt::route('/wishlist', 'store.wishlist')->name('wishlist');
Volt::route('/smartbuild', 'store.smartbuild')->name('smartbuild');
Volt::route('/product/{product}', 'store.product')->name('product');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Volt::route('/dashboard', 'dashboard.index')->name('dashboard');
    Volt::route('/dashboard/add-product', 'dashboard.add-product')->name('add-product');
    Volt::route('/dashboard/{productId}/edit', 'dashboard.edit-product')->name('edit-product');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    // Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Volt::route('/privacy-policy', 'privacy-policy')->name('privacy-policy');
Volt::route('/terms-of-use', 'terms-of-use')->name('terms-of-use');
Volt::route('/faq', 'faq')->name('faq');
Volt::route('/contact-us', 'contact-us')->name('contact-us');

require __DIR__.'/auth.php';
