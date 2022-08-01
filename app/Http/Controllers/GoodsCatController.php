<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\GoodCollection;
use App\Models\Good;

use Illuminate\Support\Facades\DB;

class GoodsCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ids = self::getCatsInner($id);
        // dd($ids);
        // $ids = [1, 2, 3, '00000071', 'ЦБ002029'];
        // return new GoodCollection(Good::whereIn('a_categoryid', $ids)->where('status', 'show')->get());
        // return new GoodCollection(Good::whereIn('a_categoryid', $ids)->where('status', 'show')->simplePaginate(10));
        return new GoodCollection(Good::whereIn('a_categoryid', $ids)->where('status', 'show')->paginate(50));
    }

    /**
     * возвращает массив a_id текущий каталог и все вложенные
     */
    public static function getCatsInner($id_cat)
    {
        // $ids = [ 1 , 2 , 3 , '00000071', 'ЦБ002029' ];
        // return new GoodCollection(Good::whereIn('a_categoryid',$ids)->where('status', 'show')->get());
        $a = DB::table('mod_020_cats as m')
            ->addSelect('m.a_id')
            ->where('m.a_parentid', $id_cat)
            // ->whereIn('id', [1, 2, 3])
            // ->get()
        ;
        $a1 = DB::table('mod_020_cats as m')
            ->join('mod_020_cats as m2', 'm2.a_parentid', '=', 'm.a_id')
            ->addSelect('m2.a_id')
            ->where('m.a_parentid', $id_cat)
            // ->whereIn('id', [1, 2, 3])
            // ->union($a)
            // ->get()
            ;

            $a = $a->union($a1);

        $a2 = DB::table('mod_020_cats as m')
            ->join('mod_020_cats as m2', 'm2.a_parentid', '=', 'm.a_id')
            ->join('mod_020_cats as m3', 'm3.a_parentid', '=', 'm2.a_id')
            ->addSelect('m3.a_id')
            ->where('m.a_parentid', $id_cat)
            // ->whereIn('id', [1, 2, 3])
            // ->union($a1)
            // ->get()
            ;
            $a = $a->union($a2);
        $a3 = DB::table('mod_020_cats as m')
            ->join('mod_020_cats as m2', 'm2.a_parentid', '=', 'm.a_id')
            ->join('mod_020_cats as m3', 'm3.a_parentid', '=', 'm2.a_id')
            ->join('mod_020_cats as m4', 'm4.a_parentid', '=', 'm3.a_id')
            ->addSelect('m4.a_id')
            ->where('m.a_parentid', $id_cat)
            // ->whereIn('id', [1, 2, 3])
            // ->union($a2)
            // ->get()
            ;
            $a = $a->union($a3);
        $a4 = DB::table('mod_020_cats as m')
            ->join('mod_020_cats as m2', 'm2.a_parentid', '=', 'm.a_id')
            ->join('mod_020_cats as m3', 'm3.a_parentid', '=', 'm2.a_id')
            ->join('mod_020_cats as m4', 'm4.a_parentid', '=', 'm3.a_id')
            ->join('mod_020_cats as m5', 'm5.a_parentid', '=', 'm4.a_id')
            ->addSelect('m5.a_id')
            ->where('m.a_parentid', $id_cat)
            // ->whereIn('id', [1, 2, 3])
            // ->union($a3)
            // ->get()
            ;
            $a = $a->union($a4);
            $aaa = $a->get();
        // dd($a1);
        $r = [];
        $r[] = $id_cat;
        // foreach( $a4 as $k ){
        foreach( $aaa as $k ){
            // dd($k);
            $r[] = $k->a_id;
        }
        return $r;
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
