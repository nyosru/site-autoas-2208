<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Banner;
use App\Http\Resources\BannerCollection;

use App\Models\Good;
use App\Http\Resources\AdverCollection;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $res = Banner::where('status','show')->get();
        // return response()->json(['data' => $res]);
        return new BannerCollection(Banner::
            // remember(60)->
            // select('id','img','link','sort')->
            orderBy('sort','DESC')->
            where('status', 'show')->get());
    }

    public function adverIndex()
    {
        // $res = Banner::where('status','show')->get();
        // return response()->json(['data' => $res]);
        return new AdverCollection(Good::
            // remember(60)->
            // select('id','img','link','sort')->
            // orderBy('id','DESC')->
            inRandomOrder()->
            where('status', 'show')->
            where('a_arrayimage','!=','')->
            where('a_price','!=','')->
            limit(120)->
            get());
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

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

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
