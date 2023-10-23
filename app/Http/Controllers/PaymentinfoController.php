<?php

namespace App\Http\Controllers;

use App\Events\AdminNotifyEvent;
use App\Models\AdminNotify;
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


    public function getParametres($paymentinfo)
    {

       $order=$paymentinfo->order;
       // return dd($order->reqs);
       $reqs=$paymentinfo->order->product->provider_product()->first()->reqs;

       foreach($order->reqs as $v){

           $lable=$v['lable'];
           $value=$v['value'];
           

       $i=0;
      
           foreach($reqs as $r){
               if($r['lable']==$v['lable']){
                   $reqs[$i]['val']=$value;
               }
               $i++;
           }

       }





       $query="";
       foreach($reqs as $r){
       $query.=$r['name']."=".$r['val']."&";
       }


       return $query;
       # code...
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
