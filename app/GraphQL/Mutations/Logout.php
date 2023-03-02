<?php


//User has Many
//Cready     Raseed 

namespace App\GraphQL\Mutations;

use Exception;
use Illuminate\Support\Facades\Auth;

class Logout
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        // Laravel Sanctum: Auth::guard(config('sanctum.guard', 'web'))
        try{
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if($args["all"])
        $user->tokens()->delete();
        //Auth::logout();

        return [
            "state"=>true,
            "message"=>$user->name,
            "errors"=>null
        ];
    }catch(Exception $e){
        return [
            "state"=>false,
            "message"=>$e->getMessage(),
            "errors"=>$e->getMessage()
        ];
        }
    }
}
