<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.coins.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $coins=Coin::where('main_coin','=',0)->get();
        $roles=[];
        $data=[];
        foreach ($coins as $c) {
            # code...
            //1
            $roles[]=[
                'coin_value'.$c->id=>'numeric|required|min:1'
            ];
            $data[]=[
                'id'=>$request['coin_id'.$c->id],
                'value'=>$request['coin_value'.$c->id],
                'name'=>$request['coin_name'.$c->id],
                'img'=>$request['coin_img'.$c->id]
            ];
        }
        $roles=[$roles];

        $r=[
            'coin_value1'=>['required','numeric']
        ];
        $this->validate($request,$r);



        foreach ($coins as $c) {
            # code...
            //
            $c->update([
                'id'=>$request['coin_id'.$c->id],
                'value'=>$request['coin_value'.$c->id],
                'name'=>$request['coin_name'.$c->id],
                'icon'=>$request['coin_img'.$c->id],
                'nickname'=>$request['coin_nickname'.$c->id],
            ]);
        }

        return back()->with('status','تم تعديل البيانات بنجاح');
        return 'no problame';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin $coin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        //
    }
}
