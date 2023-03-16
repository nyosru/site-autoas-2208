<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{


    /**
     *  отправка звонка для подтверждения номера
     */
    public function smsConfirm(string $phone)
    {
        $res = file_get_contents('https://api.ucaller.ru/v1.0/initCall?key='.env('UCALLER_KEY', 'xx').'&service_id='.env('UCALLER_SERVICE_ID', '11').'&phone=' . $phone);
        return response()->json($res);
    }

    /**
     *  при выхове этой функции номер делаем подтверждённым
     */
    // public function smsConfirmSend( $orderId )
    public function smsConfirmSend($phone, $code = '')
    {
        $phone1 = self::phoneNormalize($phone, 8);
        $res = Phone::where('phone', $phone1)
            ->whereNull('phone_confirm')
            ->update(['phone_confirm' => date('Y-m-d H:I:s')]);
        // $res = 1;
        return response()->json(['result' => $res]);
    }


    /**
     * приводим телефон к строке, начинается с 7
     * return number | show | 8
     */
    public static function phoneNormalize($str, $return = 'number')
    {
        // function phone_number($sPhone)
        // {
        $sPhone = preg_replace("[^0-9]", '', $str);
        // dd($sPhone);

        // dd( $sPhone[0] );
        // dd(substr($sPhone, 0, 1));

        if ($return == 'number') {
            return $sPhone;
        } else if ($return == 8) {
            return ($sPhone[0] == 7) ? '8' . substr($sPhone, 1, 10) : $sPhone;
        }

        if ($sPhone[0] == 7) {
            $phone = '+' . $sPhone;
        } elseif ($sPhone[0] == 8) {
            $phone = '+7' . substr($sPhone, 1, 10);
            // dD($ph);    
        }

        if (strlen($sPhone) != 11)
            return False;

        return $phone;

        // $sArea = substr($sPhone, 0, 3);
        // $sPrefix = substr($sPhone, 3, 3);
        // $sNumber = substr($sPhone, 6, 4);
        // $sPhone = "(" . $sArea . ")" . $sPrefix . "-" . $sNumber;
        // return $sPhone;
    }
    
}
