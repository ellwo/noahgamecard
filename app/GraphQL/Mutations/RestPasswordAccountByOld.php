<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

final class RestPasswordAccountByOld
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver



        $user=User::find(auth()->user()->id);


        try{

        if(Auth::guard('web')->attempt(["email"=>$user->email,
        "password"=>$args["oldpassword"]],false)){



            $user->forceFill([
                'password' => Hash::make($args['password']),
            ])->save();
            event(new PasswordReset($user));
    foreach ($user->tokens as $token) {


      //  if(Auth::guard('api')->user()->token()->id!=$token->id){
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $tokenRepository->revokeAccessToken($token->id);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
    //}
    }



    return [

        "responInfo" => [
            'state' => true,
            'message' => "تم تغيير كلمة المرور بنجاح "."\n"." يمكنك الان تسجيل الدخول ب استخدام كلمة المرور الجديدة ",
            'errors' => null,
            'code' => 200,
        ],
        'token' => ""
    ];


    }

    else{


        return [

            "responInfo" => [
                'state' => false,
                'message' => 'عذرا كلمة المرور غير صحيحة',
                'errors' => json_encode([

                        'password'=>[
                            'كلمة المرور غير صحيحة !'
                        ]
                ]),
                'code' => 500,
            ],
            'token' => null
        ];
    }

        }catch(Exception $e){


        return [

            "responInfo" => [
                'state' => false,
                'message' => $e->getMessage(),
                'errors' => json_encode([

                        'password'=>[
                            'كلمة المرور غير صحيحة !'
                        ]
                ]),
                'code' => 500,
            ],
            'token' => null
        ];
        }






    }
}
