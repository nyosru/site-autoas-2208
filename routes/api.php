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

Route::get('/getTest2', function (Request $request) {
    echo '<pre>';

    // Выводит весь результат команды оболочки "ls" и возвращает
// последнюю строку вывода в переменной $last_line. Сохраняет код возврата
// команды в $retval.
    // $last_line = system('ls', $retval);
    $last_line = system('php artisan test', $retval);

    // Выводим дополнительную информацию
    echo '
        </pre>
        <hr />Последняя строка вывода: ' . $last_line . '
        <hr />Код возврата: ' . $retval;

});

Route::get('/getTest', function (Request $request) {

    $output = null;
    $retval = null;

    if ($_SERVER['HTTP_HOST'] == '22.avto-as.ru') {
        exec('/opt/php74/bin/php artisan test', $output, $retval);
    } else {
        // exec('php artisan test', $output, $retval);
        exec('vendor/bin/phpunit', $output, $retval);
    }

    // echo "Вернёт статус $retval и значение:\n";
    echo '<pre>';

    $a1 = $a2 = [];
    $a1[] = '[37;1m';
    $a2[] = '';
    $a1[] = '[39;22m';
    $a2[] = '';
    $a1[] = '[32;1m';
    $a2[] = '';
    $a1[] = '[39m';
    $a2[] = '';
    $a1[] = '[22m';
    $a2[] = '';
    $a1[] = '[2m';
    $a2[] = '';
    $a1[] = '[30;42;1m';
    $a2[] = '';
    $a1[] = '[39;49;22m';
    $a2[] = '';

    $output2 = str_replace($a1, $a2, $output);
    // print_r($output2);

    $next = false;

    echo '<pre>';
    foreach ($output2 as $str) {
        echo $str . PHP_EOL;
    }
    echo '</pre>';

});


Route::apiResource('catalog', CatalogController::class);
Route::apiResource('goodscat', GoodsCatController::class);
Route::apiResource('good', GoodController::class);
Route::get('goodAnalog/{id}', [ GoodController::class , 'showAnalog' ]);

Route::apiResource('page', PageController::class);
Route::apiResource('banner', BannerController::class);
Route::get('adverIndex', [BannerController::class, 'adverIndex']);

Route::get('import/1c', [ImportAvtoAsController::class, 'import']);
// Route::get('import/1c2', [ImportAvtoAsController::class, 'import2']);

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
