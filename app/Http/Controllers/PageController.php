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
     * return number | show
     */
    public static function phoneNormalize($str, $return = 'number')
    {
        // function phone_number($sPhone)
        // {
        $sPhone = preg_replace("[^0-9]", '', $str);
        // dd($sPhone);

        if ($return == 'number')
            return $sPhone;

        if (strlen($sPhone) != 11)
            return False;

        $sArea = substr($sPhone, 0, 3);
        $sPrefix = substr($sPhone, 3, 3);
        $sNumber = substr($sPhone, 6, 4);
        $sPhone = "(" . $sArea . ")" . $sPrefix . "-" . $sNumber;
        return $sPhone;
    }



    /**
     *  отправка почты для подтверждения ящика
     */
    public function sendMailVerify(string $email)
    {


        $data = ['msg' => 'Привет буфет'];
        // $data['email'] = 'nyos@rambler.ru';

        Mail::to($email)
            ->send(new OrderNew($data));
        // ->queue(new OrderNew($data));
        // ->later(now()->addMinutes(1), new OrderNew($data));

    }

    /**
     *  Отправили заказ апи 1 шаг
     */
    public function sendOrder(SendOrderRequest $request)
    {

        // echo '123';
        $return = [];
        $return['validated'] =
            $validated = $request->validated();
        $return['request'] = $request->all();

        // dd(self::phoneNormalize($request->phone));
        $phone = self::phoneNormalize($request->phone);

        if (!empty($request->email)) {
            $email = $request->email;
        } else if (!empty($request->phone)) {
        }

        $data = ['msg' => 'Привет буфет'];
        $data['email'] = 'nyos@rambler.ru';

        // Mail::to($data['email'])
        //     //     ->send(new OrderNew($data));
        //     ->queue(new OrderNew($data));
        // // ->later(now()->addMinutes(1), new OrderNew($data));

        $return['user'] =
            $user = User::firstOrCreate(
                ['email' =>  $data['email']],
                [
                    'name' => $request->name ?? 'x',
                    'password' => md5(rand())
                ]
            );

        // если пользователь 
        // указал почту
        // новый или не подтвердил ещё почту ... то шлём ему почту
        if (!empty($user->email) && (!isset($user->email_verified_at) || empty($user->email_verified_at))) {
            $return['send_mail_verified'] = true;
            self::sendMailVerify($user->email);
        } else {
            $return['send_mail_verified'] = false;
        }

        $order = new Order();
        $order->user_id = $user->id;
        $oo = $order->save();
        $orId = $order->id;
        // dd([ $oo , $order ]);

        // $return['goods'] = $request->goods;
        $goodsInDb = [];
        foreach ($request->goods as $k => $v) {

            $good = [
                'good_id' => $v['id'],
                'order_id' => $orId,
                'goodOrigin' => $v['head'] . ' <br/> ' .
                    'id: ' . $v['a_id'] . ' <br/> ' .
                    'цена: ' . $v['a_price'],
                'price' => $v['a_price'],
                'kolvo' => $v['kolvo'],
            ];

            $oGood = OrderGood::create($good);
            $good['save'] = $oGood;

            $return['goods'][] =
                $goodsInDb[] = $good;

        }

        // $oGood = new OrderGood($good);
        // $order->goods()->createMany($goodsInDb);

        // name: form_name.value,
        // city: form_city.value,
        // phone: phone.value,
        // email: email.value,

        // form_needHelp: form_needHelp.value,
        // form_postedAddress: show_form_postedAddress.value == true ? form_postedAddress.value : '',

        // goods: cartAr.value,
        // event(new Registered($user));

        file_get_contents('https://api.uralweb.info/telegram.php?' . http_build_query(
            array(
                's' => '1',
                // 'id' => $to, // id кому пишем
                // 'msg' => 'пример handle(RegUserEvent $event) '. ( $event->aa ?? 'x' ) // текст сообщения
                'msg' => '22 333 sпример handle(RegUserEvent $event) ' . serialize($request->goods) // текст сообщения
            )
        ));

        return response()->json($return);
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
