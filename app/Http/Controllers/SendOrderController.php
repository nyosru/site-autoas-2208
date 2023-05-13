<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOrderRequest;
use App\Models\Good;
use App\Models\MailStop;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class SendOrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * Отправили заказ апи 1 шаг
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendOrderRequest $request)
    {

        $return = [
            'file' => __FILE__,
            'line' => __LINE__
        ];
   
        $return['request'] = $request->all();

        $return['validated'] =
            $validated = $request->validated();

        $data = [];

        $phoneIn = [];
        $userIn = [];

        $return['phone'] =
            $phone = PageController::phoneNormalize($return['validated']['phone'], '8');

        if (!empty($phone)) {
            // $userIn['phone'] = $phone;
            $phoneIn['phone'] = $phone;
        }

        if (!empty($request->email)) {
            $data['email'] =
                // $email = 
                $request->email;
        }

        if (!empty($request->phone)) {
        }

        $userIn['name'] = $request->name ?? 'x';
        $userIn['password'] = md5(rand());

        $return['user-in'] = $userIn;

        $return['user'] =
            $user = User::firstOrCreate(
                ['email' =>  $data['email']],
                $userIn
            );

        $phoneIn['user_id'] = $user->id;

        $confirm = Phone::where('phone', $phoneIn['phone'])->whereNotNull('phone_confirm')->select('phone_confirm')->first();
        if (!empty($confirm->phone_confirm)) {
            $phoneIn['phone_confirm'] = $confirm->phone_confirm;
        }
        // dd('$confirm',$confirm);

        // добавляем телефон
        $return['phone'] =
            $phoneNow = Phone::firstOrCreate(
                ['user_id' =>  $user->id, 'phone' => $phoneIn['phone']],
                $phoneIn
            );

        // dd('$phoneNow',$phoneNow);
        $return['phone_veritify'] = $phoneNow['phone_confirm'];

        // формирование заказа +
        $return['newOrder'] =
            $orderNew = OrderController::store($user, $request);

        $return['mail_in_stop_list'] = 0;
        $return['mail_verify_ranee'] = false;

        $return['mail_in_stop_list'] =
            $mailToStopList = MailStop::where('email', $user->email)->count();
        // dd('$mailToStopList',$mailToStopList);
        if ($mailToStopList == 0) {

            $return['mail_verify_ranee'] = false;
            $verifyRanee = User::where('email', $user->email)->whereNotNull('email_verified_at')->count();

            // если ранее уже подтверждали
            // if ( 1 == 2 && $verifyRanee > 0) {
            if ( $verifyRanee > 0) {
                $return['mail_verify_ranee'] = true;
                User::where('email', $user->email)->whereNull('email_verified_at')->update(['email_verified_at' => date('Y-m-d H:i:s')]);
            }
            // если ранее уже НЕ подтверждали
            else {

                // новый или не подтвердил ещё почту ... то шлём ему почту
                // if ( 1 == 1 || ( !empty($user->email) && empty($user->email_verified_at) ) ) {
                if ( ( !empty($user->email) && empty($user->email_verified_at) ) ) {
                    $return['send_mail_verified'] = true;
                    // PageController::sendMailVerify($user);
                    MailController::sendMailVerify($user);
                } else {
                    $return['send_mail_verified'] = false;
                }

            }
        }

        self::sendTelega($return, $request);
        return response()->json($return);
    }

    public static function sendTelega($return, $request)
    {

        $msg = 'новый заказ' . PHP_EOL .
            $return['user']['name'] . PHP_EOL .
            'Тел: '.( $return['phone']['phone'] ?? '..' ) . PHP_EOL .
            ( $return['user']['email'] ?? '...' ) . PHP_EOL .
            'Город: ' . $request->city . PHP_EOL .
            'Нужна помощь спец-а: ' . ($request->form_needHelp ? 'Да!' : 'Нет') .            PHP_EOL .
            'Доставка: ' . (!empty($request->form_postedAddress) ? $request->form_postedAddress : 'не нужна') .            PHP_EOL .
            PHP_EOL;

        $summa = 0;

        $addEndSumma = '';

        foreach ($request->goods as $k => $v) {
            if ($v['kolvo'] > 0) {
                $msg .= self::addStringGoodToTelegas($v);
                $summa += $v['a_price'] * $v['kolvo'];
                if (empty($v['a_price'])) {
                    $addEndSumma = ' + под заказ';
                }
            }
        }

        $msg .= 'Сумма: ' . $summa . $addEndSumma;

        file_get_contents('https://api.uralweb.info/telegram.php?' . http_build_query(
            array(
                // 's' => '1',
                's' => md5($_SERVER['HTTP_HOST']),
                'domain' => $_SERVER['HTTP_HOST'],
                // 'msg' => $_SERVER['HTTP_HOST'] . PHP_EOL . $msg,
                'msg' => $msg,
                // OrderUraBot @order_ura_bot:
                'token' => env('TELEGA_ORDERBOT_TOKEN', 'xx'),
                'id' => [   // 1368605419, // я тест
                    // серхио тест
                    // 5152088168,
                    // 2037908418 // ваш метролог
                
                    // first_name: Авто-АС
                    1022228978,
                    // Денис Авто-СА
                    663501687 ]
            )
        ));

    }

    /**
     * подготовка строки в тележку
     */
    public static function addStringGoodToTelegas($v)
    {

        $return = $v['head'] . ' (' . $v['a_id'] . ')' . PHP_EOL
            . '       ' . $v['kolvo'] . 'шт ';

        if (!empty($v['a_price'])) {
            $return .= '* ' . $v['a_price'] . ' р' . ' = ' . ($v['a_price'] * $v['kolvo']);
        } else {
            $return .=  'под заказ ';
        }

        return $return . PHP_EOL                . PHP_EOL;
    }
}
