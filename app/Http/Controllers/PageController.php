<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOrderRequest;
use App\Mail\OrderNew;
use App\Models\Order;
use App\Models\OrderGood;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    public static function mailVerifyGood(String $email)
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


    /**
     *  отправка почты для подтверждения ящика
     */
    public function sendMailVerify(User $user)
    {

        // $data = ['msg' => 'Привет буфет'];
        // $data['email'] = 'nyos@rambler.ru';

        // if (empty($user->email_verified_at)) {
        Mail::to($user->email)
            ->send(new OrderNew($user));
        // ->queue(new OrderNew($data));
        // ->later(now()->addMinutes(1), new OrderNew($data));
        // dd($rr);
        // }
    }

    /**
     *  Отправили заказ апи 1 шаг
     */
    public function sendOrder(SendOrderRequest $request)
    {

        // echo '123';
        $return = [];

        $return['request'] = $request->all();

        $return['validated'] =
            $validated = $request->validated();

        // dd($return);
        // dd(self::phoneNormalize($request->phone));

        $data = [];

        $userIn = [];

        $return['phone'] =
            $phone = self::phoneNormalize($return['validated']['phone'], '8');

        if (!empty($phone)) {
            $userIn['phone'] = $phone;
        }

        if (!empty($request->email)) {
            $data['email'] =
                // $email = 
                $request->email;
        }
        if (!empty($request->phone)) {
        }


        // $data = ['msg' => 'Привет буфет'];
        // $data['email'] = 'nyos@rambler.ru';

        // Mail::to($data['email'])
        //     //     ->send(new OrderNew($data));
        //     ->queue(new OrderNew($data));
        // // ->later(now()->addMinutes(1), new OrderNew($data));

        $userIn['name'] = $request->name ?? 'x';
        $userIn['password'] = md5(rand());

        $return['user-in'] = $userIn;

        $return['user'] =
            $user = User::firstOrCreate(
                ['email' =>  $data['email']],
                $userIn
            );

        // формирование заказа +
        $return['newOrder'] =
            $orderNew = OrderController::store($user, $request);

        // dd( [ 77 , $orderNew->toArray() ] );

        // if( $orderNew ){
        // }

        // $order = new Order;
        // $order->user_id = $user->id;
        // $return['order_add'] =
        //     $order->save();
        // $return['order_id'] = $order->id;
        // // формирование заказа -

        // // добавляем товары в заказ + 
        // $return['goods'] = [];
        // foreach ($request->goods as $good) {

        //     try {

        //         // $g = [ 'id'=>$good['id'],
        //         // 'name'=>$good['name'],
        //         // 'price'=>$good['price'],
        //         // ];

        //         // $return['goods'][] = $good;
        //         $good['analog'] = ''; 
        //         $return['goods'][] = $good;

        //         $g = new OrderGood;
        //         $g->order_id = $return['order_id'];
        //         $g->good_id = $good['id'];
        //         $g->goodOrigin = $good['head'];
        //         $g->price = $good['a_price'];
        //         $g->kolvo = $good['kolvo'];
        //         $g->save();

        //         $return['goods'][] = $g->id;

        //     } catch (\Exception $ex) {
        //         $return['goods'][] = $ex->getMessage();

        //     }
        // }
        // // добавляем товары в заказ -

        // dd($return);

        // если пользователь 
        // указал почту
        // новый или не подтвердил ещё почту ... то шлём ему почту

        if (!empty($user->email) && empty($user->email_verified_at)) {
            $return['send_mail_verified'] = true;
            self::sendMailVerify($user);
        } else {
            $return['send_mail_verified'] = false;
        }

        // // try {
        // $order = new Order();
        // $order->user_id = $user->id;
        // $oo = $order->save();

        // // $orId = $order->id;
        // // dd([ $oo , $order ]);
        // // } catch (\Throwable $th) {
        // //     //throw $th;
        // //     dd($th->getMessage());
        // // }

        // // $return['goods'] = $request->goods;
        // $goodsInDb = [];

        $msg = 'новый заказ' . PHP_EOL .
            $return['user']['name'] . PHP_EOL .
            $return['user']['phone'] . PHP_EOL .
            $return['user']['email'] . PHP_EOL .
            'Город: ' . $request->city . PHP_EOL .
            'Нужна помощь спеца: ' . ($request->form_needHelp ? 'Да!' : '') .            PHP_EOL .
            'Доставка: ' . (!empty($request->form_postedAddress) ? $request->form_postedAddress : 'не нужна') .            PHP_EOL .
            PHP_EOL;
        $summa = 0;
        foreach ($request->goods as $k => $v) {

            $msg .= $v['head'] . ' (' . $v['a_id'] . ')' . PHP_EOL .
                $v['a_price'] . ' * ' . $v['kolvo'] . ' = ' . ($v['a_price'] * $v['kolvo'])
                . PHP_EOL
                . PHP_EOL;
            $summa += $v['a_price'] * $v['kolvo'];
            // $good = [
            //     'good_id' => $v['id'],
            //     'order_id' => $order->id,
            //     'goodOrigin' => $v['head'] . ' <br/> ' .
            //         'id: ' . $v['a_id'] . ' <br/> ' .
            //         'цена: ' . $v['a_price'],
            //     'price' => $v['a_price'],
            //     'kolvo' => $v['kolvo'],
            // ];

            // $oGood = OrderGood::create($good);

            // $return['goods'][] =
            //     $goodsInDb[] = $oGood;

            // $return['goods'][] =
            //     $goodsInDb[] = $good;

        }

        $msg .= 'Сумма: ' . $summa;

        // // $oGood = new OrderGood($good);
        // // $order->goods()->createMany($goodsInDb);

        // // name: form_name.value,
        // // city: form_city.value,
        // // phone: phone.value,
        // // email: email.value,

        // // form_needHelp: form_needHelp.value,
        // // form_postedAddress: show_form_postedAddress.value == true ? form_postedAddress.value : '',

        // // goods: cartAr.value,
        // // event(new Registered($user));

        file_get_contents('https://api.uralweb.info/telegram.php?' . http_build_query(
            array(
                's' => '1',
                // 'id' => $to, // id кому пишем
                // 'msg' => 'пример handle(RegUserEvent $event) '. ( $event->aa ?? 'x' ) // текст сообщения
                // 'msg' => '22 333 sпример handle(RegUserEvent $event) ' . serialize($request->goods) // текст сообщения
                'msg' => $_SERVER['HTTP_HOST'] . PHP_EOL . $msg,
                // OrderUraBot @order_ura_bot:
                'token' => '5960307100:AAHshaEf6WXw4rKbDg-JCeAyOEsFoHqZmNA'
            )
        ));

        return response()->json($return);
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

        # Запуск события с передачей объекта события
        // // $response = event('RegUserEvent', ['name' => 'привет буфет']);
        // // $email = 'nyos@rambler.ru';
        // // $email = 'support@php-cat.com';
        // $email = 'boss@uralweb.info';
        // echo $email;
        // event('NewOrderEvent', [['name' => 'test '.rand(), 'email' => $email]]);

        // event(new Registered($user));


        // $data = ['msg' => 'Привет буфет'];
        // $data['email'] = 'nyos@rambler.ru';
        // Mail::to($data['email'])
        //     ->send(new OrderNew($data));



        // ->queue(new OrderNew($data));
        // ->later(now()->addMinutes(1), new OrderNew($data));

        // Mail::send(
        //     // $data['email'],
        //     'emails.newOrder.confirm',
        //     ['kod' => rand()]
        // );

        // file_get_contents('https://api.uralweb.info/telegram.php?' . http_build_query(
        //     array(
        //         's' => '1',
        //         // 'id' => $to, // id кому пишем
        //         // 'msg' => 'пример handle(RegUserEvent $event) '. ( $event->aa ?? 'x' ) // текст сообщения
        //         'msg' => '11 пример handle(RegUserEvent $event) ' . serialize($data) // текст сообщения
        //     )
        // ));

        return view('welcome');
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
     * @param  int  $id
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

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

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
