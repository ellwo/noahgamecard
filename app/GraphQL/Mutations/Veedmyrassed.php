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
      $ra= RassedActevity::create([
        'amount'=>400,
        "paymentinfo_id"=>$payinfo->id,
        "code"=>$args["input"]["code"],
        "rassed_id"=>$rassed->id
       ]);


       $this->send([
        "id"=>$ra->id,
        'title'=>'نجحت العملية',
        'body'=>'تمت اضافة الرصيد'.$ra->amount.'$ بنجاح']
        ,$user);

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


    function send($req,$user){
        $url = 'https://fcm.googleapis.com/fcm/send';

        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK',
         'id' => $req["id"]??0,
         'status'=>"done");
        $notification = array(
        'title' =>$req['title']??"",
        'body' => $req['body']??"",
        'image'=> $req['img']??"",
        'sound' => 'default',
        'badge' => '1',);
        $arrayToSend = array(
        'to' => $user->f_token->token,
        'notification' => $notification,
        'data' => $dataArr,
        'priority'=>'high');

        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: key=' . config('firebase.server_key'),
            'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        //var_dump($result);
        curl_close ( $ch );

    }


}
