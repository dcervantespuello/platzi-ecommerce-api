<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserTokenController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\QualificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('server-error', function () {
    abort(500);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::post('sanctum/token', UserTokenController::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('newsletter', [NewsletterController::class, 'send']);

    Route::post('qualify/user/{id}', [QualificationController::class, 'rateUser']);

    Route::post('qualify/product/{id}', [QualificationController::class, 'rateProduct']);

    Route::post('unrate/product/{id}', [QualificationController::class, 'unrateProduct']);

    Route::post('approve/rating/{rating}', [QualificationController::class, 'approve']);

    Route::get('rating', [QualificationController::class, 'list']);
});
