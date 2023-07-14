<?php

namespace App\Http\Controllers;

use App\Http\Resources\GoodResource;
use App\Models\GoodAnalog;
use Illuminate\Http\Request;

use App\Http\Resources\GoodCollection;
use App\Models\Good;
use Illuminate\Support\Facades\DB;

class GoodController extends Controller
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
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {

        // $request->search

        $s = explode(' ', $request->search);
        // $s = explode(' ', $request->search);


        return new GoodCollection(Good::with('analog')->where(function ($query) use ($s, $request) {
            foreach ($s as $v) {

                $v2 = preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '', $v);

                // $query->where('a', '=', 1)
                //       ->orWhere('b', '=', 1);
                $query->Where('head', 'LIKE', '%' . $v2 . '%');
            }
            $query->orWhere('catnumber_search', $v2);

            if (strlen($request->search) <= 20 && strlen($request->search) >= 5) {
                $searchString = strtolower(preg_replace('/[^a-zA-Zа-яА-Я0-9xA0x20]/ui', '', $request->search));
                // die($ee);
                $query->orWhere('catnumber_search', $searchString );
            }

            // if (!empty($s2))
            //     $query->orWhere('catnumber_search', $s2);

        })
            // ->orWhere(function ($query) use ($request) {
            //     if (sizeof($request->search) <= 20) {
            //         $s2 = preg_replace('/[^a-zA-Zа-яА-Я0-9 ]/ui', '', $request->search);
            //         $query->where('catnumber_search', $s2);
            //     }
            // })
            ->where('status', 'show')->
            // orderBy('a_price')->
            limit(150)->get());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return GoodResource
     */
    public function show($id)
    {
//        $good = Good::with('analog')->where('a_id', $id)->where('status', 'show')->get();
        if( class_exists(Debugbar))
        \Debugbar::error( __LINE__ , 'show' );

        try{

            if( class_exists(Debugbar))
            \Debugbar::error( __LINE__ , 'show' , 'try' );

////        $good = Good::where('a_id', $id)->where('status', 'show')->get();
//            $good2 =
//        $good = Good::with('analog')->where('a_id', $id)->where('status', 'show')->get();

            $good2 =
//        $good = Good::with('good_analog')->where('a_id', $id)->where('status', 'show')->get();
        $good = Good::with('analog')->where('a_id', $id)->where('status', 'show')->get();



//            \Debugbar::error($good);
//            \Debugbar::error( [ 2 , $good[0]->analog ?? 55 ] );
//            \Debugbar::error( 777 );
//            $good2[0]['analog']
//            if( empty($good[0]->analog->items) ){
//            if( empty($good[0]['analog']) ){
            if( 1 == 1 ){
//                \Debugbar::error( 123 , __LINE__ );

//                $good2[0]['analog1'] = GoodAnalog::with('angood')->take(5)->get();
//                $good2[0]['analog2'] = GoodAnalog::with('analog2')->take(5)->get();
//                $good2['analog'] =
                $good2[0]['analog'] = DB::table('mod_021_items_analogs')
                    ->join('mod_021_items','mod_021_items.catnumber_search', 'LIKE', 'mod_021_items_analogs.art_analog')
//                    ->where( 'mod_021_items_analogs.art_origin' , $good[0]->a_catnumber)
                    ->where( 'mod_021_items_analogs.art_origin' , $good[0]->catnumber_search)
//                    ->take(5)
                    ->get();

//                $good2[0]['analog'] = GoodAnalog::with('angood')
////                ->where( 'art_origin' , 'LIKE', $good2['a_catnumber'])
//                ->where( 'art_origin' , $good[0]->a_catnumber)
//                ->get()
//            ;
//                \Debugbar::error( 1231 , $good2['analog'] );
            }

//////        return new GoodCollection(Good::with('analog')->where('a_id', $id)->where('status', 'show')->get());
////
//////        dd($good);
//////        dd($good->items[0]->analog);
//////        dd($good->items);
//////        dd($good[0]);
//////        dd($good[0]->relations);
////        $g = $good->toArray();
////        $good2 = $g[0] ?? null;
//////        dd($good2);
////
//////            \Debugbar::error($g[0]);
//            \Debugbar::error($good2);
////            \Debugbar::error(json($good2));
//////            \Debugbar::message('Error!');
////
////        if( 1 ==2 && !empty($good2) && empty($good2['analog']) ){
//////        if( 1 == 1 ){
//////            dd(__LINE__);
////
//            $ana = GoodAnalog::with('angood')
////                ->where( 'art_origin' , 'LIKE', $good2['a_catnumber'])
//                ->where( 'art_origin' , $good2['a_catnumber'])
//                ->get()
//            ;
////            $good2['anals'] =
//            $ee = $ana->toArray();
//
////            $good2['analog'] = [];
//
//            foreach( $ee as $ana ){
////                $good2['analog'][] = $ana['angood'];
//                $good2->analog[] = $ana['angood'];
//            }
////
//////                \Debugbar::error($good2);
//////            dd($ee);
////
////        }
//
////            return response()->json(['data' => $good2]);

        }catch ( \Exception $ex ){

            $good2 = [ 'error' => $ex->getMessage() ];
//            \Debugbar::error( __LINE__ );
            \Debugbar::error( $ex->getMessage() );
        }

//        return new GoodCollection($good);
//        return new GoodCollection($good2);
//        return new GoodResource($good2);
//        return response()->json([ 'data' => ['data' => $good2] ]);
        return response()->json(['data' => $good2]);
        // return new GoodCollection(Good::with('analog')->where('a_id', 'LIKE', $id)->where('status', 'show')->get());
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
