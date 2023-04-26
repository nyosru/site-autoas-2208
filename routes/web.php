<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\PageController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

// Route::get('/ess', function ( ) { 
//     $user = User::limit(1)->get();
//     // dd($user);
//     return view( 'emails.newOrder.confirm', [ 'user' => $user[0], 'domain' => $_SERVER['HTTP_HOST'] ] );
// });

Route::get('/email/verify/{email}', [MailController::class, 'store'] );

Route::get(
    '/{any?}/{any2?}/{any3?}/{any35?}/{any34?}/{any33?}/{any32?}/{any31?}',
    [PageController::class, 'index']
);    














// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::get('/s', function () { return view('emails.newOrder.confirm'); });

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
