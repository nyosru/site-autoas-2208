<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderGood;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(User $user, Request $request)
    {

        $return = [
            'file' => __FILE__
        ];

        $order = new Order;
        $order->user_id = $user->id;
        // $return['order_add'] =
        $order->save();
        $return['order_id'] = $order->id;
        // формирование заказа -

        // добавляем товары в заказ + 
        $return['goods'] = [];
        foreach ($request->goods as $good) {
            // dd( $good );
            if (!empty($good['kolvo']) && $good['kolvo'] > 0){
                $return['goods'][] = OrderGoodController::store($order, $good);
            }

            // try {

            //     // $g = [ 'id'=>$good['id'],
            //     // 'name'=>$good['name'],
            //     // 'price'=>$good['price'],
            //     // ];

            //     // $return['goods'][] = $good;
            //     $good['analog'] = '';
            //     $return['goods'][] = $good;

            //     $g = new OrderGood;
            //     $g->order_id = $return['order_id'];
            //     $g->good_id = $good['id'];
            //     $g->goodOrigin = $good['head'];
            //     $g->price = $good['a_price'];
            //     $g->kolvo = $good['kolvo'];
            //     $g->save();

            //     $return['goods'][] = $g->toArray();
            // } catch (\Exception $ex) {
            //     $return['goods'][] = $ex->getMessage();
            // }

        }
        // добавляем товары в заказ -
        // return $return;
        return $order;
        // return true;
    }
}
