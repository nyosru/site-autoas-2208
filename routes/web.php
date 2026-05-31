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
|
*/

// Route::get('/ess', function ( ) { 
//     $user = User::limit(1)->get();
//     // dd($user);
//     return view( 'emails.newOrder.confirm', [ 'user' => $user[0], 'domain' => $_SERVER['HTTP_HOST'] ] );
// });

Route::get('/email/verify/{email}', [MailController::class, 'store'] );

// VK авторизация
Route::get('/auth/vk/redirect', [\App\Http\Controllers\AuthController::class, 'vkRedirect']);
Route::get('/auth/vk/callback', [\App\Http\Controllers\AuthController::class, 'vkCallback']);

// Админ-панель (защищённая зона)
Route::prefix('admin')->group(function () {
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return redirect('/admin/pages');
        });
        Route::get('pages', [\App\Http\Controllers\AdminController::class, 'pages']);
        Route::get('pages/{id}/edit', [\App\Http\Controllers\AdminController::class, 'pageEdit'])
            ->middleware('role:owner');
        Route::get('pages/{id}/edit-ck', [\App\Http\Controllers\AdminController::class, 'pageEditCkeditor'])
            ->middleware('role:owner');
        Route::put('pages/{id}', [\App\Http\Controllers\AdminController::class, 'pageUpdate'])
            ->middleware('role:owner');
        Route::post('upload-image', [\App\Http\Controllers\AdminController::class, 'uploadImage'])
            ->middleware('role:owner');

        Route::middleware('role:owner')->group(function () {
            Route::get('roles', [\App\Http\Controllers\RoleController::class, 'index']);
            Route::put('roles/{id}', [\App\Http\Controllers\RoleController::class, 'update']);
        });
    });
});

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
