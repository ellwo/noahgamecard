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


            $fromDate= date('Y-m-d H:i:s',strtotime($args['fromDate']));
            //  strtotime($args['fromDate']??$user->created_at);
            $toDate=date('Y-m-d H:i:s',strtotime($args['toDate']));

        $_GET["page"] = $args["page"]??1;
        \request()->request->set("page", 1);

        $porders =  $user->paymentinfos()->has('orders')->with('orders')
        ->whereBetween('created_at',[$fromDate,$toDate])->orderBy('created_at', 'desc')->paginate(20);

            return [

            "responInfo"=>[
                "state"=>true,
            "errors"=>null,
            "message"=>"تم بنجاح ".$args["fromDate"]."||".$toDate." "
            ],
            'orders_gr' => $porders,
            'paginatorInfo' => [
                'total' => $porders->total(),
                'hasMorePages' => $porders->hasMorePages(),
                "currentPage"=>$args["page"]??1
            ]

        ];
        }
        else{
            return [
                "responInfo"=>[
                    "state"=>false,
                "errors"=>"خطاء",
                "message"=>"غير مسجل دخول"
                ],
                "orders_gr"=>null,
                "paginatorInfo"=>null

            ];
        }
    }
}
