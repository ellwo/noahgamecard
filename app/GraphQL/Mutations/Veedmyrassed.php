<?php

namespace App\GraphQL\Mutations;

use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\RassedActevity;
use App\Models\User;
use Exception;

final class Veedmyrassed
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        try{$user=User::find(auth()->user()->id);

      $rassed= $user->rassed;
      $paymentmethod= Paymentmethod::find($args["input"]["paymentmethod_id"]);
      $payinfo= Paymentinfo::create([
        "paymentmethod_id"=>$paymentmethod->id,
        "total_price"=>400,
        "code"=>$args["input"]["code"],
        "accepted"=>true,
        "state"=>$paymentmethod->is_auto_check?1:0,
       ]);
       RassedActevity::create([
        'amount'=>400,
        "paymentinfo_id"=>$payinfo->id,
        "code"=>$args["input"]["code"],
        "rassed_id"=>$rassed->id
       ]);

       return [
        "state"=>true,
        "message"=>"تمت اضافة الرصيد بنجاح",
        "errors"=>null
       ];

    }
       catch(Exception $e){

        return [
            "state"=>false,
            "message"=>$e->getMessage(),
            "errors"=>$e->getMessage()
        ];

       }


    }


}
