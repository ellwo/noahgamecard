<?php

namespace App\GraphQL\Mutations;

use App\Models\Coin;
use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\RassedActevity;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Validator;

final class CreateNewPaymentOrder
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver


        $vildat = Validator::make(
            $args['input'],
        [
        'paymentmethod_id'=>['required','exists:paymentmethods,id']]
         );

         if($vildat->fails()){
            return [
                'state'=>false,
                'errors'=>json_encode($vildat->errors()),
                'message'=>$vildat->errors(),
                'id'=>null,
                'code'=>402,
                'paymetninfo'=>null
            ];
         }

        if($args['input']['paymentmethod_id']==2){
            return $this->payFromRassed($args);
        }

        else{
            return $this->pay($args);
        }



    }



    function payFromRassed($args) : array {

        $vildat = Validator::make(
            $args['input'],
        [
        'paymentmethod_id'=>['required','exists:paymentmethods,id']]
         );

         if($vildat->fails()){
            return [
                'state'=>false,
                'errors'=>json_encode($vildat->errors()),
                'message'=>$vildat->errors(),
                'id'=>null,
                'code'=>402,
                'paymetninfo'=>null
            ];
         }




        $orders=[];
        $user=User::find(auth()->user()->id);
        $total_price=0;
        $orginal_price=0;

        foreach($args["input"]["orders_input"] as $v){
            $order=Order::create([
                'product_id'=>$v["product_id"],
                "qun"=>$v["qun"],
                "g_id"=>$v["g_id"],
                "email"=>$v["email"]??"",
                "password"=>$v['password']??"",
                "user_id"=>$user->id,
                'reqs'=>$v['reqs']
            ]);
            $orginal_price+=($order->qun*$order->product->price);
            $total_price+=$order->total_price();
            $orders[]=$order;
        }


        if($total_price>$user->rassed->rassedy()){
            $delorders= Order::whereIn('id',$orders)->get();
            foreach($delorders as $o){
             $o->delete();
            }
            return [
             "state"=>false,
             "message"=>"ليس لديك الرصيد الكافي  \n اجمالي المبلغ  : "." $ ".$total_price."\n رصيدك الحالي :"." $ ".$user->rassed->rassedy(),
             "paymentinfo"=>null,
             "errors"=>null
            ];
         }
        $paymentinfo=new Paymentinfo();
        $paymentinfo->paymentmethod_id=$args["input"]["paymentmethod_id"];
        $paymentinfo->total_price=$total_price;
        $paymentinfo->orginal_total=$orginal_price;
        $paymentinfo->user_id=$user->id;
        $paymentinfo->code=rand(45,80).time();
        $paymentinfo->state=1;
        $paymentinfo->save();
        $paymentinfo->orders()->saveMany($orders);

      $rassedActivite=  RassedActevity::create([
            'amount'=>-$paymentinfo->total_price,
            'paymentinfo_id'=>$paymentinfo->id,
            'rassed_id'=>$user->rassed->id,
            'code'=>$paymentinfo->code,
            'coin_id'=>Coin::where('main_coin','=',true)->pluck('id')->first()
        ]);

        $data=[
            "type"=>"veed_rassed",
            "routeInfo"=>[
                "routeName"=>"rassed",
                "data"=>$paymentinfo,
            ],
            "created_at"=>date('Y/m/d H:i:s')
          ];
        $noti=UserNotification::create([
            "id"=>$rassedActivite->id,
            'title'=>'نجحت العملية',
            'body'=>'تم خصم  من رصيدك مبلغ '.' '.$rassedActivite->amount.' مقابل شراء طلب رقم  '.$rassedActivite->paymentinfo_id,
        'user_id'=>$user->id,
          'data'=>$data
    ]);


        return [
            "state"=>true,
            "id"=>$paymentinfo->id,
            "message"=>"تم بنجاح- طلبك تحت المراجعة",
            "errors"=>null,
            "code"=>200,
            'paymentinfo'=>$paymentinfo
        ];
        return [];
    }

    function pay($args) : array {
        $vildat = Validator::make(
            $args['input'],
        ['code'=>['unique:paymentinfos,code','required','min:6','max:10'],
        'paymentmethod_id'=>['required','exists:paymentmethods,id']]
         ,[
            'code.unique'=>'هذا الكود مستخدم بالفعل ',
            'code.min'=>'يجب ان يكون الكود 6 ارقام على الاقل',
            'code.max'=>'يجب ان يكون الكود 11 ارقام على الاكثر',
            'code.required'=>'يجب ادخال الكود',
         ]);

         if($vildat->fails()){

            return [
                'state'=>false,
                'errors'=>json_encode($vildat->errors()),
                'message'=>$vildat->errors(),
                'id'=>null,
                'code'=>402
            ];
         }



        $orders=[];
        $user=User::find(auth()->user()->id);
        $total_price=0;
        $orginal_price=0;

        foreach($args["input"]["orders_input"] as $v){
            $order=Order::create([
                'product_id'=>$v["product_id"],
                "qun"=>$v["qun"],
                "g_id"=>$v["g_id"],
                "email"=>$v["email"]??"",
                "password"=>$v['password']??"",
                "user_id"=>$user->id,
                'reqs'=>$v['reqs']
            ]);
            $orginal_price+=($order->qun*$order->product->price);
            $total_price+=$order->total_price();
            $orders[]=$order->id;
        }
        $paymentinfo=new Paymentinfo();
        $paymentinfo->paymentmethod_id=$args["input"]["paymentmethod_id"];
        $paymentinfo->total_price=$total_price;
        $paymentinfo->orginal_total=$orginal_price;
        $paymentinfo->user_id=$user->id;
        $paymentinfo->code=$args["input"]["code"];
        $paymentinfo->save();
        $paymentinfo->orders()->saveMany($orders);
        return [
            "state"=>true,
            "id"=>$paymentinfo->id,
            "message"=>"تم بنجاح- طلبك تحت المراجعة",
            "errors"=>null,
            "code"=>200,
            'paymentinfo'=>$paymentinfo
        ];
    }
}
