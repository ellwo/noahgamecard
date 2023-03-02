<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;

final class CencelOrder
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {

        $order=Order::find($args["order_id"]??-1);

        if($order!=null && $order->user_id==auth()->user()->id){
            $order->processe_token()->delete();
            $order->delete();

            return
            [
                "state"=>true
            ];
        }
        else
        return
        [
            "state"=>false
        ];


        // TODO implement the resolver
    }
}
