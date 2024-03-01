<?php

use Illuminate\Support\Facades\Route;
// use App\Models\Product;
// use App\Models\User;
// use App\Models\Rating;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    /**
     * Ejercicio de relación belongsTo y hasMany
     */
    // $product = Product::find(1);
    // $user = User::find(5);
    // dd($product->user, $user->products);

    /**
     * Ejercicio de relación uno a uno polimórfica
     */
    // $product = Product::find(1);
    // $user = User::find(1);
    // $rating = Rating::find(1);
    // dd($product->rating, $user->rating, $rating->rateable, $rating->qualifier);

    return view('welcome');
});
