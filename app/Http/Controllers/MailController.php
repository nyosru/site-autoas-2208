<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->email);

        $validator = Validator::make(['email' => $request->email], [
            'email' => 'required|email',
        ]);

        // // есть ошибки во входящих данных
        if ($validator->fails()) {

            return redirect('/');

            //     $errors = $validator->fails();
            //     // $e = [];
            //     //     foreach ($errors->all() as $message) {
            //     // $e[] = $message;        
            //     //     }

            //     // dd(['error', $errors , $good]);
            //     // return redirect('post/create')
            //     //             ->withErrors($validator)
            //     //             ->withInput();
            //     return false;

        }
        // // нет ошибки во входящих данных
        // else {

        //     // Получить проверенные данные...
        $validated = $validator->validated();
        //     // dd($validated);

        User::where('email', $validated['email'])->whereNull('email_verified_at')->update(['email_verified_at' => date('Y-m-d H:i:s')]);

        return redirect('/dop/mailVerify/' . $validated['email']);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
