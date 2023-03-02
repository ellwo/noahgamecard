<?php

namespace App\GraphQL\Queries;

use App\Models\User;

final class GetConfirmdOrders
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        $user=User::find(auth()->user()->id);
        if($user!=null){
        return [

            "responInfo"=>[
                "state"=>true,
            "errors"=>null,
            ],
            "orders_gr"=>$user->orders_gr()
        ];


        }
    }
}
