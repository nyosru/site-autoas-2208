<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use Exception;

class PageController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {
        # Запуск события с передачей объекта события
        // $response = event('RegUserEvent', ['name' => 'привет буфет']);
        $email = 'nyos@rambler.ru';
        $email = 'support@php-cat.com';
        echo $email;

        event('NewOrderEvent', [['name' => 'привет буфет 333', 'email' => $email]]);

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
