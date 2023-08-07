<?php

namespace App\Http\Controllers;

use App\Models\Paymentinfo;
use Illuminate\Http\Request;

class PaymentinfoController extends Controller
{
    //



    public function __construct()
{
    $this->middleware(['permission:ادارة الطلبات']);
}
    public function index(Request $request){

        return view('admin.orders.index');
    }

    public function show(Paymentinfo $paymentinfo){

        return view('admin.orders.show',['paymentinfo'=>$paymentinfo]);
    }


    public function update(Request $request,Paymentinfo $paymentinfo){

        $paymentinfo->state=$request["state"];
        $paymentinfo->note=$request["note"]??"تم تنفيذ الطلب ";
        $paymentinfo->save();

        return redirect()->route('paymentinfo')->with('status','تم الحفظ بنجاح');


        return view('admin.orders.show',['paymentinfo'=>$paymentinfo]);
    }


}
