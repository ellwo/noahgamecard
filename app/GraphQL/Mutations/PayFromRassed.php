<?php

namespace App\GraphQL\Mutations;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\RassedActevity;
use App\Models\User;
use App\Models\UserNotification;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

final class PayFromRassed
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {

try{



    $user=User::find(auth()->user()->id);

    $or_price=0;
        $orders=[];

        $sum_total=0;
        foreach($args["input"]["orders_input"] as $v){
            $order=Order::create([
                'product_id'=>$v["product_id"],
                "qun"=>$v["qun"],
                "g_id"=>$v["g_id"],
                "email"=>$v["email"],
                "password"=>$v['password'],
                "user_id"=>$user->id
            ]);
            $orders[]=$order->id;
            $or_price+=$order->qun*$order->product->price;
            $sum_total+=$order->total_price();
        }


        if($sum_total>$user->rassed->rassedy()){

           $delorders= Order::whereIn('id',$orders)->get();

           foreach($delorders as $o){
            $o->delete();
           }

           return [
            "state"=>false,
            "message"=>"ليس لديك الرصيد الكافي",
            "paymentinfo"=>null,
            "errors"=>"ليس لديك الرصيد الكافي"
           ];
        }


      $payinfo=Paymentinfo::create(
            [
                'paymentmethod_id'=>2,
                "code"=>rand(450,800).time(),
                "state"=>1,
                "accepted"=>true,
                "orginal_total"=>$or_price,
                'total_price'=>$sum_total,
                'user_id'=>$user->id
            ]
            );

            $payinfo->orders()->attach($orders);
            //$payinfo->total_price=$sum_total;
           // $payinfo->save();
            $rassedActivite=RassedActevity::create([
                "rassed_id"=>$user->rassed->id,
                "paymentinfo_id"=>$payinfo->id,
                "amount"=>-$sum_total,
                "code"=>$payinfo->code
            ]);

       $noti=UserNotification::create([
        "id"=>$rassedActivite->id,
        'title'=>'نجحت العملية',
        'body'=>'تم خصم  من رصيدك مبلغ '.' '.$rassedActivite->amount.' مقابل شراء طلب رقم  '.$rassedActivite->paymentinfo_id,
    'user_id'=>$user->id]);

            return [
                "state"=>true,
                "errors"=>null,
                "message"=>"تم بنجاح"
            ];
        }
            catch(Exception $e){
                return [
                    "state"=>false,
                    "errors"=>$e->getMessage(),
                    "message"=>$e->getMessage()
                ];

            }



        // TODO implement the resolver
    }

}
