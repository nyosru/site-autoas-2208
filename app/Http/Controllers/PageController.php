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
use Phpcatcom\Api\AllAutopartsService;
use Illuminate\Support\Facades\App;

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
        $sPhone = preg_replace("[^0-9]", '', $str);

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
        }


        if (strlen($sPhone) != 11)
            return False;

        return $phone;
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
     * при выхове этой функции номер делаем подтверждённым
     * @param $phone
     * @return JsonResponse
     */
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
     * @param $email
     * @return void
     */
    public function mailVerify($email)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $in = [
            'aa' => ''
        ];

        return view('welcome', $in);
    }

    /**
     * Display a listing of the resource.
     */
    public function apiIndex()
    {
        return response()->json(['data' => Page::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->name = $request->input('name', $page->name);
        $page->opis = $request->input('opis', $page->opis);
        $page->html = $request->input('html', $page->html);
        $page->save();

        return response()->json(['data' => $page]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {
        $res = Page::where('module', $page)->get();

        if (!empty($res[0])) {
            return response()->json(['data' => $res[0]]);
        } else {
            abort(404);
        }
    }

    public function getApiAllAutoparts(string $search)
    {
        return AllAutopartsService::get(1, '113354', 'x', '1154');
    }

}
