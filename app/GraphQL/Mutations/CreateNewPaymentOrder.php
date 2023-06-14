<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\User;
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
        ['code'=>['unique:paymentinfos,code','required','min:6','max:10']]
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
                'message'=>'يبدو ان الكود الذي ادخلته غير صحيح ',
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
                "email"=>$v["email"],
                "password"=>$v['password'],
                "user_id"=>$user->id
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
        $paymentinfo->orders()->attach($orders);


        return [
            "state"=>true,
            "id"=>$paymentinfo->id,
            "message"=>"تم بنجاح- طلبك تحت المراجعة",
            "errors"=>null,
            "code"=>200,
        ];






    }
}
