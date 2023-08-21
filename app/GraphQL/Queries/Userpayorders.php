<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;

final class Userpayorders
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        if(isset($args['fromDate']) && isset($args['toDate'])){

            try{
                $user = User::find(auth()->user()->id);
                if ($user != null) {


                    if ($args['fromDate'] == null && $args['toDate']==null) {
                        $fromDate = date('Y-m-d H:i:s', strtotime($user->created_at));
                        $toDate = now();
                    }

                    else if($args['toDate']==null){
                        $fromDate = date('Y-m-d H:i:s',
                        strtotime($args['fromDate']));
                        $date=new DateTime($fromDate);
                        $toDate=$date->modify('+24 hours');
                        $toDate=date('Y-m-d H:i:s',strtotime($toDate->format('Y-m-d H:i:s')));
                    }

                    else {
                        $fromDate = date('Y-m-d H:i:s', strtotime($args['fromDate']));
                        //  strtotime($args['fromDate']??$user->created_at);
                        $toDate = date('Y-m-d H:i:s', strtotime($args['toDate']));
                        $d=new Carbon(strtotime($toDate),"Asia/Aden");

                        $days=now()->diffInDays($d);
                        if($days==0)
                        {
                            $toDate=now();
                        }
                        else{

                            $date=new DateTime($toDate);
                            $toDate=$date->modify('+24 hours');
                            $toDate=date('Y-m-d H:i:s',strtotime($toDate));

                        }

                    }
                    $_GET["page"] = $args["page"] ?? 1;
                    \request()->request->set("page", 1);

                    $porders =  $user->paymentinfos()->whereHas('orders')
                        ->whereBetween('created_at', [$fromDate, $toDate])
                        ->orderBy('created_at', 'desc')->paginate(20);


                        /**->where('id','LIKE','%'.$args['search']."%")
                    ->whereHas('orders',function($q)use($args){
                        $q->where('orders.reqs','LIKE','%'.$args['search']."%");
                    }) */
                    return [

                        "responInfo" => [
                            "state" => true,
                            "errors" => null,
                            "message" => "تم بنجاح " . $fromDate . "||" . $toDate . " "
                        ],
                        'orders_gr' => $porders,
                        'paginatorInfo' => [
                            'total' => $porders->total(),
                            'hasMorePages' => $porders->hasMorePages(),
                            "currentPage" => $args["page"] ?? 1
                        ]

                    ];
                } else {
                    return [
                        "responInfo" => [
                            "state" => false,
                            "errors" => "خطاء",
                            "message" => "غير مسجل دخول"
                        ],
                        "orders_gr" => null,
                        "paginatorInfo" => null

                    ];
                }


            }catch(Exception $e){
                return [
                    "responInfo" => [
                        "state" => false,
                        "errors" => "خطاء"+isset($args),
                        "message" => $e->getMessage()
                    ],
                    "orders_gr" => null,
                    "paginatorInfo" => null

                ];

            }
        }
        else{

            $user=User::find(auth()->user()->id);
            $porders =  $user->paymentinfos()->whereHas('orders')
            ->orderBy('created_at', 'desc')->paginate(20);

            return [

                "responInfo" => [
                    "state" => true,
                    "errors" => null,
                    "message" => "Done"
                ],
                'orders_gr' => $porders,
                'paginatorInfo' => [
                    'total' => $porders->total(),
                    'hasMorePages' => $porders->hasMorePages(),
                    "currentPage" => $args["page"] ?? 1
                ]

            ];
        }

    }
}
