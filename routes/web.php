<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

Route::get(
    '/{any?}/{any2?}/{any3?}/{any35?}/{any34?}/{any33?}/{any32?}/{any31?}',
    [PageController::class, 'index']
);    

// Route::get(
//     '/{any?}/{any2?}/{any3?}/{any35?}/{any34?}/{any33?}/{any32?}/{any31?}',
//     function () {



//         # Запуск события с передачей объекта события
//         // $response = event('RegUserEvent', ['name' => 'привет буфет']);
//         $email = 'nyos@rambler.ru';
//         $email = 'support@php-cat.com';
//         echo $email;
//         event( 'NewOrderEvent' , [ [ 'name' => 'привет буфет' , 'email' => $email ] ]);

//         return view('welcome');
//     }
// );
    
// Route::get('/{?any}', function () {    return view('welcome');});
