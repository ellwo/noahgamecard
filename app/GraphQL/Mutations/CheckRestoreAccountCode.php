<?php

namespace App\GraphQL\Mutations;

use App\Models\PhoneCode;
use App\Models\Processetoken;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class CheckRestoreAccountCode
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {


        if ($args['code'] != null) {

            $user = User::where($args['type'], '=', $args['input'])->first();

            $res = PhoneCode::where('code', '=', $args['code'])->where('phone', '=', $args["input"])
                ->where('user_id', '=', $user->id)->where('ex_at', '>', now())->first();


            if ($res != null) {
                $token =  Str::random(8);
                $token .= time();
                $token .= $user->email;
                $date = new DateTime('now');
                $date->modify('+59 minutes');

                $hashed_token = Hash::make($token);

                $processe_token = Processetoken::create([
                    'processe_id' => $res->id,
                    'processe_type' => get_class($res),
                    'token' => $hashed_token,
                    'expired_at' => $date,
                    'user_id' => $user->id
                ]);


                return
                    [
                        "responInfo" => [

                            'state' => true,
                            'message' => 'تم التأكيد',
                            'errors' => null,
                            'code' => 200,
                        ],
                            'token' => $token,
                            'email' => base64_encode($user->email),
                            'code' => base64_encode($args['code']),


                    ];
            }

            else{


                return
                    [
                        "responInfo" => [

                            'state' => false,
                            'message' => 'الكود الذي ادخلته غير صحيح',
                            'errors' => null,
                            'code' => 400,
                        ],
                        'token' => null,
                        'email' =>
                        null,
                        'code' =>
                        null,


                    ];
            }

        }else{

            return
            [
                "responInfo" => [

                    'state' => false,
                    'message' => 'الرجاء ادخال الكود ',
                    'errors' => null,
                    'code' => 400,
                ],
                'token' =>
                 null,
                'email' =>
                null,
                'code' =>
                null,
            ];

        }



        // TODO implement the resolver
    }
}
