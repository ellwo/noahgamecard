<?php

namespace App\GraphQL\Mutations;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\RassedActevity;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

final class ConfirmOrderPay
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {   // TODO implement the resolver

        $data=$args["input"];


        $vildat = Validator::make(
            $args["input"],
            [
                "order_id"=>['required','exists:orders,id'],
                'token'=>['required'],
                'paymentmethod_id'=>['required','exists:paymentmethods,id']
            ]
         );


        if ($vildat->fails()) {


            return [
                "state"=>false,
                "message"=>"فشلت العملية الرجاء التحقق من صحة المعلومات المدخلة",
                "errors"=>json_encode($vildat->errors()),
            ];
        }
        else{

            if($this->check_order($data['token'],$data["order_id"]))
            {





            $paymentinfo=Paymentinfo::create([
                'code'=>$data["code"],
                'paymentmethod_id'=>$data["paymentmethod_id"],
                'prove_img'=>$request['img']??""
            ]);


            $paymentMethod=$paymentinfo->paymentmethod;

            $order=Order::find($data["order_id"]);
            $paymentinfo->orders()->save($order);
            $order->state=1;
            $order->processe_token()->delete();

            $user=User::find(auth()->user()->id);

            $sum_total=0;
            $dissum_total=0;
            $o_price=0;

            foreach($paymentinfo->orders as $or)
            {

                $total_price=$order->product->price * $order->qun;
                $o_price+=$order->product->price * $order->qun;

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


            $paymentinfo->total_price=$sum_total;
            $paymentinfo->orginal_total=$o_price;
            $paymentinfo->save();
            $order->save();




            if($paymentMethod->is_auto_check){
                //here we will check api of payment Method code
                        $paymentinfo->accepted=true;
                        $paymentinfo->state=1;
                        $paymentinfo->save();



                        if($paymentMethod->id==2)
                        $acteviti=RassedActevity::create([
                            "rassed_id"=>$user->rassed->id,
                            "paymentinfo_id"=>$paymentinfo->id,
                            "amount"=>-$sum_total,
                            "code"=>"Str::"
                        ]);


            }

            else{
                $paymentinfo->accepted=false;
                $paymentinfo->state=0;
                $paymentinfo->save();

            }






            return [
                "state"=>true,
                "id"=>$paymentinfo->id,
                "paymentinfo"=>$paymentinfo,
                "total"=>$dissum_total,
                'dtotal'=>$sum_total,
                "message"=>"تمت العملية بنجاح سيتم معالحة طلبك قريبا",
                "errors"=>null,
            ];
        }



        else{


            return [
                "state"=>false,
                "message"=>"فشلت العملية يرجى اعادة المحاولة مرة اخرى",
                "errors"=>json_encode($data),
            ];

        }




        }




    }



   public function check_order($token,$order_id){
    $token=$token;
    $order=Order::find($order_id);
    if($order==null)
    return false;

    else{
    $oldtoken=$order->processe_token->first();
    $expired_at=date_create($oldtoken->expired_at);
    $dif=now()->isAfter($expired_at);
    $comper=Hash::check( $oldtoken->token,$token);
    if(!$dif &&$comper && $order->user->id ==auth()->user()->id){
    return true;
    }
    else
    return false;

    }
}
}
