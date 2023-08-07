<?php

namespace App\GraphQL\Mutations;

use App\Models\FirebaseToken;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

final class ChangeFToken
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {



        if (Auth::check()) {
            try {
                $user = User::find(auth()->user()->id);
                $tok = FirebaseToken::updateOrCreate(
                    [
                        'token' => $args["f_token"],
                    ],
                    [
                        "user_id" => $user->id,
                        'device_id'=>$args["device_id"],
                        'device_name'=>$args["device_name"],
                        'device_ip'=>request()->ip(),
                    ]
                );

                return [
                    'state' => true,
                    'message' => 'تم بنجاح'
                ];
            } catch (Exception $e) {
                return [
                    'state' => false,
                    'message' => $e->getMessage()
                ];
            }

        }
        else{


            $tok = FirebaseToken::updateOrCreate(
                [
                    'device_id' => $args["device_id"],
                ],
                [
                    'token'=>$args["f_token"],
                    'device_name'=>$args["device_name"],
                    'device_ip'=>request()->ip(),
                    "user_id"=>null
                ]
            );

            return [
                'state' => true,
                'message' => 'تم بنجاح',
                'errors'=>null,

            ];
        }


        // TODO implement the resolver
    }
}
