<?php

namespace App\GraphQL\Mutations;

use App\Models\FirebaseToken;
use App\Models\User;
use Exception;

final class ChangeFToken
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
try{
        $user =User::find(auth()->user()->id);


        $tok=FirebaseToken::updateOrCreate([
            'token'=>$args["f_token"],
        ],[
            "user_id"=>$user->id
        ]
        );

        return [
            'state'=>true,
            'message'=>'تم بنجاح'

        ];}
        catch(Exception $e){
            return [
                'state'=>false,
                'message'=>$e->getMessage()
            ];
        }


        // TODO implement the resolver
    }
}
