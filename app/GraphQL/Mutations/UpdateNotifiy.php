<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Exception;

final class UpdateNotifiy
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

            $notifiy=$user->user_notifications()->where('id','=',$args["id"]??0)->first();
            if($notifiy!=null){
            $notifiy->state=1;
        return[
            "message"=>"",
            "state"=>true,
            "errors"=>null
        ]    ;
        }

        else{
            return[
                "message"=>"غير موجود",
                "state"=>false,
                "errors"=>null
            ]    ;

        }

        }
        catch(Exception $e){
            return[
                "message"=>$e->getMessage(),
                "state"=>false,
                "errors"=>null
            ]    ;

        }
    }
}
