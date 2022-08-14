<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoodsCatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BannerController;

use App\Http\Controllers\ImportAvtoAsController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('catalog', CatalogController::class );
Route::apiResource('goodscat', GoodsCatController::class );
Route::apiResource('good', GoodController::class );
Route::apiResource('page', PageController::class );
Route::apiResource('banner', BannerController::class );
Route::get('adverIndex', [ BannerController::class , 'adverIndex' ] );
Route::get('import/1c', [ ImportAvtoAsController::class , 'import' ] );