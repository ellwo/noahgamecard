<?php

namespace App\GraphQL\Mutations;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Processetoken;
use App\Models\Product;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

final class CreateOrder
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {






        if(Auth::check())
{

    $required_ep=false;
        if(isset($args["input"]["product_id"])){
            $product=Product::find($args["input"]["product_id"]);
            if($product!=null)
            $required_ep=$product->required_ep;
        }
        if($required_ep)
       $roles=['product_id' => ['required','exists:products,id']
        ,'g_id'=>['required'],
        'email'=>['required','email'],
        'password'=>['required','min:8'],
        'qun'=>['required','min:0','integer']
    ];
    else
$roles=['product_id' => ['required','exists:products,id']
        ,'g_id'=>['required'],
        'qun'=>['required','min:0','integer']
    ];

        $vildat = Validator::make(
            $args["input"],
            $roles
         );


        if ($vildat->fails()) {
        return $date=[
            'errors'=>json_encode($vildat->errors()),
            'state'=>false,
            'code'=>405,
            'order'=>null,
            'token'=>null,
            'expired_at'=>null
        ];
        }


        else{




            return $this->create_order($args["input"]);
        }


    }
    else{

        $verrors=[
            "AuthErrors"=>'ليس مسجل دخول'
        ];
        return[
        'errors'=>json_encode($verrors),
            'state'=>false,
            'code'=>502,
            'order'=>null,
            'token'=>null,
            'expired_at'=>null];
    }



        // TODO implement the resolver
    }


    public function create_order($request){

        $user=auth()->user();
        $order=Order::create([
            'product_id'=>$request['product_id'],
            'qun'=>$request['qun'],
            'user_id'=>$user->id,
            'g_id'=>$request['g_id'],
            'email'=>$request['email']??"",
            'password'=>$request['password']??"",
            'state'=>0,
        ]);
          $token=  Str::random(8);
          $token.=time();
          $date=new DateTime('now');
          $date->modify('+20 minutes');

          $processe_token=Processetoken::create([
            'processe_id'=>$order->id,
            'processe_type'=>get_class($order),
            'token'=>$token,
            'expired_at'=>$date,
            'user_id'=>auth()->user()->id
        ]);



        $total_price=0.0;
        $dis_total_price=0.0;
        //$

         $total_price=$order->product->price * $order->qun;
         $dis_total_price= $total_price;

        $offer=$order->product->hasOffer();
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

        return [
            'errors'=>null,
            'state'=>true,
            'order'=>$order,
            'code'=>200,
            'total_price'=>$total_price,
            'dtotal_price'=>$dis_total_price,
            'token'=>Hash::make($token),
            'expired_at'=>$processe_token->expired_at

        ];
        //$processe_token->processe()->


      }


}
