<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\RassedActevity;
use App\Models\User;
use Illuminate\Http\Request;

class RassedActevityContoller extends Controller
{



    public function __construct()
{
    $this->middleware(['permission:ادارة التغذية']);
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        return view('admin.rassed.index');

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
        $paymthods=Paymentmethod::where('id','!=',2)->get();
        return view('admin.rassed.veed_rassed',[
            'paymthods'=>$paymthods
        ]);
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
        // return dd($_POST);

        $this->validate($request,[
            'user_id'=>['required','exists:users,id'],
            'code'=>['required','unique:paymentinfos,code'],
            'amount'=>['required']
        ]);


        $paymentinfo=Paymentinfo::create([
            'user_id'=>$request['user_id'],
            'state'=>0,
            'total_price'=>$request['amount'],
            'orginal_price'=>$request['amount'],
            'code'=>$request['code']??rand(14555,8755),
            'paymentmethod_id'=>$request['paymentmethod_id'],
        ]);

        $user=User::find($request['user_id']);
        $rassed_id=$user->rassed->id;
        RassedActevity::create([
            'amount'=>$request['amount'],
            'paymentinfo_id'=>$paymentinfo->id,
            'rassed_id'=>$rassed_id,
            'code'=>$paymentinfo['code']
        ]);
        $paymentinfo->state=2;
        $paymentinfo->save();

        return redirect()->route('rasseds')->with('status','تم تغذية الحساب بنجاح');




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function show(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function edit(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function destroy(RassedActevity $rassedActevity)
    {
        //
    }
}
