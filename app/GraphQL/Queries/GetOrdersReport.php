<?php

namespace App\GraphQL\Queries;

use App\Models\Paymentinfo;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;

final class GetOrdersReport
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver


        try{

            $user=User::find(auth()->user()->id);

            $fromDate = date('Y-m-d H:i:s', strtotime($user->created_at));
            $toDate = now();

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

                    $toDate=$toDate->format('Y-m-d H:i:s');
                    //$toDate=date('Y-m-d H:i:s',strtotime($toDate->format('Y-m-d H:i:s')));

                }

            }



            $userorders=$user->orders()
            ->whereHas('paymentinfo',function($q)use($fromDate,$toDate){

                $q->where('state','!=',3)
                ->whereBetween('created_at', [$fromDate, $toDate]);
        })->get() ;

        $pays=Paymentinfo::whereHas('orders',function($q)use($userorders){

            $q->whereIn('id',$userorders->pluck('id')->toArray());
        });
        $total_price=$pays->sum('total_price');
        $orginal_total=$pays->sum('orginal_total');

            return [
                        "responInfo" => [
                            "state" => true,
                            "errors" => null,
                            "message" => "تم بنجاح " . $fromDate."sum==" . "||" . $toDate . " "
                        ],
                        "orders" => $userorders,
                        'total_price'=>$total_price,
                        'orginal_total'=>$orginal_total

                    ];

        }catch(Exception $e){

            return [
                "responInfo" => [
                    "state" => false,
                    "errors" => "خطاء",
                    "message" => $e->getMessage()
                ],
                'orders'=>null
            ];
        }

        // else {
        //     return [
        //         "responInfo" => [
        //             "state" => false,
        //             "errors" => "خطاء",
        //             "message" => "غير مسجل دخول"
        //         ],
        //         "orders_gr" => null,
        //         "paginatorInfo" => null

        //     ];


    }
}
