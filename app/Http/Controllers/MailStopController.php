<?php

namespace App\Http\Controllers;

use App\Models\MailStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailStopController extends Controller
{
    public function store(Request $request)
    {


        $validator = Validator::make([ 'email' => $request->email ] , [
            // 'head' => 'required|unique:posts|max:255',
            'email' => 'required|email|unique:mail_stops',
            // 'head' => 'required|max:255',
            // 'a_price' => 'required',
            // 'kolvo' => 'required|min:1',
        ]);

        // есть ошибки во входящих данных
        if ($validator->fails()) {

            // $errors = $validator->fails();
            // $e = [];
            //     foreach ($errors->all() as $message) {
            // $e[] = $message;        
            //     }

            // dd(['error', $errors , $good]);
            // return redirect('post/create')
            //             ->withErrors($validator)
            //             ->withInput();
            // return false;
            return response()->json([
                'res' => false
            ]);
        }
        // нет ошибки во входящих данных
        else {

            // Получить проверенные данные...
            $validated = $validator->validated();
            // dd($validated);

            $g = new MailStop;
            $g->email = $validated['email'];
            $g->save();

            return response()->json([
                'res' => true,
                'data' => $g
            ]);
        }

        // dd(['$emailStop', $request->email, $request->all()]);
        // return MailStop::insert(['mail'=>$request->email]);
    }
}
