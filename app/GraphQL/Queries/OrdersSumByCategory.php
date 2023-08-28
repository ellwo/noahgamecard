<?php

namespace App\GraphQL\Queries;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;

final class OrdersSumByCategory
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
                    $toDate=date('Y-m-d H:i:s',strtotime($toDate->format('Y-m-d H:i:s')));
                }

            }

            $pays=$user->paymentinfos()->has('orders')
            ->where('state','>',0)
            ->where('state','<',3)
            ->whereBetween('created_at', [$fromDate, $toDate]);


            $ordersSum=[];

            $departments=Order::whereIn('paymentinfo_id',$pays->pluck('id')->toArray())->
            withSum(['product:price'])->get()->groupBy(function($data){
                return $data->department->name;
            });


          //  return dd($departments);
            foreach($departments as $k=>$v){
                $ordersSum[]=[
                    'name'=>$k,
                    'total_price'=>$v->sum('product_price_sum'),
                    'count'=>count($v)
                ];
            }

            $data=[
                'responInfo'=>[
                    'state'=>true,
                    'message'=>'تم بنجاح',
                    'code'=>200,
                    'errors'=>null
                ],
                'sums'=>$ordersSum,
                'orginal_total'=>$pays->sum('orginal_total'),
                'total_price'=>$pays->sum('total_price')

            ];

            return $data;
        }catch(Exception $e){


        $data=[
            'responInfo'=>[
                'state'=>false,
                'message'=>$e->getMessage(),
                'code'=>500,
                'errors'=>null
            ],
            'sums'=>[],
            'orginal_total'=>0,
            'total_price'=>0

        ];

        return $data;
        }


    }
}
