<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOrderRequest;
use App\Mail\OrderNew;
use App\Models\MailStop;
use App\Models\Order;
use App\Models\OrderGood;
use http\QueryString;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\Phone;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Phpcatcom\Api\AllAutoParts\Services\AllAutopartsService;
use Illuminate\Support\Facades\App;


//use Phpcatcom\Api\AllAutoParts\Controllers\AllAutoPartsController;
//use Phpcatcom\Api\AllAutoParts\Services\AllAutopartsService;

class PageController extends Controller
{

    public static function mailVerifyGood(string $email)
    {
        return redirect('/')->with('emailVerify', $email);
    }

    public static function customRegistration(Request $request)
    {

        $dataVal = $request->validate([
            'name' => 'required',
            'city' => '',
            'email' => 'required|email|unique:users',
            'phone' => 'min:5',
            // 'password' => 'required|min:6',
        ]);

        // $data = $request->all();
        // $check = $this->create($data);
        // $check = self::createUser($data);
        $check = self::createUser($dataVal);

        return redirect("dashboard")->withSuccess('You have signed-in');
    }


    public static function createUser(array $data)
    {
        try {
            $r = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            event(new Registered($data));
            return $r;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
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

        if (strlen($sPhone) == 10) {
            $sPhone = '8' . $sPhone;
        }

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

    /**
     *  отправка звонка для подтверждения номера
     */
    public function smsConfirm(string $phone)
    {
        $res = file_get_contents('https://api.ucaller.ru/v1.0/initCall?key=uRmr0VI3HISaACc1v7EFtY1IXlvjLB0L&service_id=529316&phone=' . $phone);
        return response()->json($res);
    }

    /**
     *  при выхове этой функции номер делаем подтверждённым
     */
    // public function smsConfirmSend( $orderId )
    public function smsConfirmSend($phone)
    {
        $phone1 = self::phoneNormalize($phone, 8);
        // $res = file_get_contents('https://api.ucaller.ru/v1.0/initCall?key=uRmr0VI3HISaACc1v7EFtY1IXlvjLB0L&service_id=529316&phone=' . $phone);
        // $res = User::find( $orderId )->update(['phone_confirm' => date('Y-m-d H:I:s')]);
        $res = User::where('phone', $phone1)
            ->whereNull('phone_confirm')
            ->update(['phone_confirm' => date('Y-m-d H:I:s')]);
        // $res = 1;
        return response()->json(['result' => $res]);
    }



    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function mailVerify($email)
    {
    }


    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {

        $in = [
//            'asd' => \Phpcatcom\Api\AllAutoParts\Services\AllAutopartsService::get(1, 'as', 'asd', 'фильтр'),
//            'asd' => \Phpcatcom\Api\Services\AllAutopartsService::get(1, 'as', 'asd', 'фильтр'),
            'asd' => \Phpcatcom\Api\AllAutopartsService::get(1, '113354', 'asd', '1154'),
            'aa' => ''
        ];


//        $classes = App::getClasses();
//
//        foreach ($classes as $class) {
////            echo $class . '<br>';
//            $in['aa'] .= $class . '<br>';
//        }

        return view('welcome', $in);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {

        // dd($page);
        $res = Page::where('module', $page)->get();

        if (!empty($res[0])) {
            return response()->json(['data' => $res[0]]);
        } else {
            // return response(view('view_name'), 404);
            // new Exception('error', 404);
            abort(404);
        }
    }

    public function getApiAllAutoparts(string $search)
    {
        return json_encode( [ 1, AllAutopartsService::get(1, '113354', 'x', $search) ] );
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
