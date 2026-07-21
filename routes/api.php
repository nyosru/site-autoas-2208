<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GoodController;
use App\Services\VkMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

//Route::get('allautoparts/{search}', function (Request $request) {
//Route::get('allautoparts/{search}', function ($search) {
//    return file_get_contents('https://api74.php-cat.com/allautoparts/api.php?ss=da&search=' . $search);
//});
Route::get('allautoparts/{search}', [PageController::class, 'getApiAllAutoparts']);


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
Route::get('goodAnalog/{id}', [GoodController::class, 'showAnalog']);


Route::get('pages', [PageController::class, 'apiIndex']);
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

Route::get('test-vk', function () {

    $msg = 'Тестовое сообщение из '.($_SERVER['HTTP_HOST'] ?? 'сайта').'. Время: '.now();
    $vkId = 5903492;

    $log = [];

    // === 1. Проверка конфигов ===
    $log['config'] = [
        'env_VK_SERVICE_TOKEN' => env('VK_SERVICE_TOKEN') ? '***'.substr(env('VK_SERVICE_TOKEN'), -10) : 'NOT SET',
        'env_VK_GROUP_ORDER_TOKEN' => env('VK_GROUP_ORDER_TOKEN') ? '***'.substr(env('VK_GROUP_ORDER_TOKEN'), -10) : 'NOT SET',
        'env_VK_GROUP_ID' => env('VK_GROUP_ID'),
        'env_VK_GROUP_ORDER_ID' => env('VK_GROUP_ORDER_ID'),
        'config_services_vk_service_token' => config('services.vk.service_token') ? '***'.substr(config('services.vk.service_token'), -10) : 'NOT SET',
        'config_order_vk_service_token' => config('services.vk.order_token') ? '***'.substr(config('services.vk.order_token'), -10) : 'NOT SET',
        'config_services_vk_group_id' => config('services.vk.group_id'),
        'config_щ order_vk_group_id' => config('services.vk.order_group_id'),
    ];
    Log::info('TEST-VK: config check', $log['config']);

    // === 2. VkGroupMessageService ===
    $log['vkGroupService'] = ['attempted' => true];
    try {
        $vkService = app(\App\Services\VkGroupMessageService::class);
        $log['vkGroupService']['canSendFromGroup'] = $vkService->canSendFromGroup($vkId);
        $result = $vkService->sendToUserWithResult($vkId, $msg);
        $log['vkGroupService']['sendResult'] = $result;
        Log::info('TEST-VK: sendToUserWithResult', $result);
    } catch (\Throwable $e) {
        $log['vkGroupService']['exception'] = $e->getMessage();
        Log::error('TEST-VK: VkGroupMessageService exception', ['message' => $e->getMessage()]);
    }

    // === 3. Прямой запрос к VK API ===
    $log['directVkApi'] = ['attempted' => true];
    try {
        $token = env('VK_SERVICE_TOKEN');
        if ($token) {
            $response = \Illuminate\Support\Facades\Http::asForm()->timeout(30)->post('https://api.vk.com/method/messages.send', [
                'access_token' => $token,
                'user_id' => $vkId,
                'message' => $msg,
                'random_id' => random_int(1, 2147483647),
                'v' => '5.131',
            ]);
            $log['directVkApi']['http_status'] = $response->status();
            $log['directVkApi']['body'] = $response->json();
            Log::info('TEST-VK: direct VK API', [
                'http_status' => $response->status(),
                'body' => $response->json(),
            ]);
        } else {
            $log['directVkApi']['error'] = 'VK_SERVICE_TOKEN not set in env';
            Log::error('TEST-VK: direct VK API - token missing');
        }
    } catch (\Throwable $e) {
        $log['directVkApi']['exception'] = $e->getMessage();
        Log::error('TEST-VK: direct VK API exception', ['message' => $e->getMessage()]);
    }

    return response()->json($log);
});
