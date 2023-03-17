<?php

namespace App\GraphQL\Queries;

use App\Models\User;

final class Userpayorders
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
        $orders=$user->orders_gr($args["page"]??1);
            return [

            "responInfo"=>[
                "state"=>true,
            "errors"=>null,
            "message"=>"تم بنجاح"
            ],
            "orders_gr"=>$orders['orders_gr'],
            'paginatorInfo'=>$orders['paginatorInfo']

        ];
        }
        else{
            return [
                "responInfo"=>[
                    "state"=>false,
                "errors"=>"خطاء",
                "message"=>"غير مسجل دخول"
                ],
                "orders_gr"=>null

            ];
        }
    }
}
