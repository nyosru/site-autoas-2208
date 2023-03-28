<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoodsCatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BannerController;

use App\Http\Controllers\ImportAvtoAsController;
use App\Http\Controllers\MailStopController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\SendOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/11/{domain}', function (Request $request,$domain) {
//     $dns = dns_get_record($domain);
//     // print_r($dns);
//     dd($dns);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('catalog', CatalogController::class);
Route::apiResource('goodscat', GoodsCatController::class);
Route::apiResource('good', GoodController::class);
Route::apiResource('page', PageController::class);
Route::apiResource('banner', BannerController::class);
Route::get('adverIndex', [BannerController::class, 'adverIndex']);
Route::get('import/1c', [ImportAvtoAsController::class, 'import']);

// отправить заказ
// Route::post('orger', [ PageController::class , 'sendOrder' ] );
// Route::any('orger', [PageController::class, 'sendOrder']);
Route::apiResource('order', SendOrderController::class)
    ->only(['store']);

// Route::post('smsConfirmSend/{phone}/{code}', [PageController::class, 'smsConfirmSend']);
Route::any('smsConfirmSend/{phone}/{code?}', [PhoneController::class, 'smsConfirmSend']);
// Route::post('smsConfirm/{phone}', [PageController::class, 'smsConfirm']);
Route::post('smsConfirm/{phone}', [PhoneController::class, 'smsConfirm']);

Route::apiResource('emailStop', MailStopController::class);
// Route::resource('emailStop', MailStopController::class);
