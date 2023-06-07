<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::route('index_ticket');
});

Auth::routes();


    Route::get('/ticket', [TicketController::class, 'index_ticket'])->name('index_ticket');

Route::middleware(['admin'])->group(function() {

    Route::get('/ticket/create', [TicketController::class, 'create_ticket'])->name('create_ticket');
    Route::post('/ticket/create', [TicketController::class, 'store_ticket'])->name('store_ticket');
    Route::get('/ticket/{ticket}/edit', [TicketController::class, 'edit_ticket'])->name('edit_ticket');
    Route::patch('/ticket/{ticket}/update', [TicketController::class, 'update_ticket'])->name('update_ticket');
    Route::delete('/ticket/{ticket}', [TicketController::class, 'delete_ticket'])->name('delete_ticket');   
    Route::post('/order/{order}/confirm', [OrderController::class, 'confirm_payment'])->name('confirm_payment');
});

Route::middleware(['auth'])->group(function() {

    Route::get('/ticket/{ticket}', [TicketController::class, 'show_ticket'])->name('show_ticket');
    Route::post('/cart/{ticket}', [CartController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('/cart', [CartController::class, 'show_cart'])->name('show_cart');
    Route::patch('/cart/{cart}', [CartController::class, 'update_cart'])->name('update_cart');
    Route::delete('/cart/{cart}', [CartController::class, 'delete_cart'])->name('delete_cart');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/order', [OrderController::class, 'index_order'])->name('index_order');
    Route::get('/order/{order}', [OrderController::class, 'show_order'])->name('show_order');
    Route::post('/order/{order}/pay', [OrderController::class, 'submit_payment_receipt'])->name('submit_payment_receipt');
    Route::get('/profile', [ProfileController::class, 'show_profile'])->name('show_profile');
    Route::post('/profile',[ProfileController::class, 'edit_profile'])->name('edit_profile');
});


