<?php

namespace App\GraphQL\Mutations;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

final class PayCartOrders
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {




try{



    $user=User::find(auth()->user()->id);

        $orders=[];
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
        }


      $payinfo=Paymentinfo::create(
            [
                'paymentmethod_id'=>$args["input"]["paymentmethod_id"],
                "code"=>$args["input"]["code"],
                "state"=>0
            ]
            );

            $payinfo->orders()->attach($orders);

            $sum_total=0;
            $dissum_total=0;

            foreach($payinfo->orders as $or)
            {

                $total_price=$order->product->price * $order->qun;
                $dis_total_price= $total_price;

               $offer=$or->product->hasOffer();
               if($offer!=null)
              {
               $dis_total_price=$offer->p_dic * $order->qun;
              }

            else{
               $role=$user->hasRole('تاجر');

                 if($role==true)
               {
                 $role_id=Role::where('name','=','تاجر')->pluck('id')->first();
              $dis_persint=Discount::whereHas('role',
                 function (Builder $query)use($role_id){
                    $query->where('id','=',$role_id);
                      })->first();

                       $dis_total_price= $total_price-($total_price*$dis_persint->dis_persint);
            }
              }

              $sum_total+=$dis_total_price;
              $dissum_total+=$dis_total_price;
            }
            $payinfo->total_price=$sum_total;
            $payinfo->save();
            return [
                "state"=>true,
                "errors"=>null,
                "message"=>"تمت العملية بنجاح ",
                "paymentinfo"=>$payinfo
            ];
        }
            catch(Exception $e){
                return [
                    "state"=>false,
                    "errors"=>$e->getMessage(),
                    "message"=>$e->getMessage(),
                    "paymentinfo"=>null
                ];

            }



        // TODO implement the resolver
    }
}
