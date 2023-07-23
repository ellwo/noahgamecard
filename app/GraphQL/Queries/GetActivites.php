<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

final class GetActivites
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {


            $user=User::find(auth()->user()->id);



           $data_pays=  $user->paymentinfos()->
            where('state','>',0)->where('state','<',3)
            ->where('paymentmethod_id','=',2)->whereHas('rassed_actevity',function($query){
                $query->where('amount','<',0);
            });






          $veed=  $user->rassed_acetvities()->whereHas('paymentinfo',function($query){
                $query->where('state','>',0)->where('state','<',3);
            })->where('amount','>',0)->sum('amount');

            $anlyes=[


            ];


            if(!isset($args['lastdate'])){
            $activites= $user->acivites_groupByDate($args["page"]??1);
            return [
                'activites'=>$activites['activites'],
                'paginatorInfo'=>$activites['paginatorInfo'],
                'orginal_total'=>$data_pays->sum('orginal_total'),
                'total_price'=>$data_pays->sum('total_price'),
                'veed_total'=>$veed,
            ];
        }
        else{
            $todyz=date('Y-m-d H:i:s',strtotime($args['lastdate']));
      //      return dd($todyz);
            $date=new DateTime($todyz);
            $activites= $user->lastacivites_groupByDate($date);
            return [
                'activites'=>$activites['activites'],
                'orginal_total'=>$data_pays->sum('orginal_total'),
                'total_price'=>$data_pays->sum('total_price'),
                'veed_total'=>0,
            ];

        }




        // TODO implement the resolver
    }
}
