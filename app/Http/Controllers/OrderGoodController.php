<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderGoodController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Order $order, $good)
    {

        $validator = Validator::make($good, [
            // 'head' => 'required|unique:posts|max:255',
            'id' => 'required',
            'head' => 'required|max:255',
            'a_price' => 'required',
            'kolvo' => 'required|min:1',
        ]);

        // есть ошибки во входящих данных
        if ($validator->fails()) {

            $errors = $validator->fails();
            // $e = [];
            //     foreach ($errors->all() as $message) {
            // $e[] = $message;        
            //     }

            // dd(['error', $errors , $good]);
            // return redirect('post/create')
            //             ->withErrors($validator)
            //             ->withInput();
            return false;
            
        } 
        // нет ошибки во входящих данных
        else {

            // Получить проверенные данные...
            $validated = $validator->validated();
            // dd($validated);

            $g = new OrderGood;
            $g->order_id = $order->id;
            $g->good_id = $validated['id'];
            $g->goodOrigin = $validated['head'];
            $g->price = $validated['a_price'];
            $g->kolvo = $validated['kolvo'];
            $g->save();

            return $g;
        }

        // // Получить часть проверенных данных...
        // // $validated = $validator->safe()->only(['name', 'email']);
        // // $validated = $validator->safe()->except(['name', 'email']);

        // $return = [];

        // // $g = [ 'id'=>$good['id'],
        // // 'name'=>$good['name'],
        // // 'price'=>$good['price'],
        // // ];

        // // $return['goods'][] = $good;
        // $good['analog'] = '';
        // $return['goods'][] = $good;

        // $g = new OrderGood;
        // $g->order_id = $order->id;
        // $g->good_id = $good['id'];
        // $g->goodOrigin = $good['head'];
        // $g->price = $good['a_price'];
        // $g->kolvo = $good['kolvo'];
        // $g->save();

        // return $g;
    }
}
