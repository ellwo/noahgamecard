<?php

namespace App\GraphQL\Mutations;

use App\Models\PhoneCode;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

final class RestPasswordAccount
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver





        try{

            $email = base64_decode($args['email']);
            $code = base64_decode($args['code']);
            $token = $args['token'];
            $type = $args['type'];

            $user = User::where('email', '=', $email)->first();

            $res = null;
            if ($type == "email") {

                $res = PhoneCode::where('phone', '=', $user->email)
                    ->where('code', '=', $code)
                    ->where('user_id', '=', $user->id)
                    ->where('ex_at', '>', now())->first();
            } else {
                $res = PhoneCode::where('phone', '=', $user->phone)
                    ->where('code', '=', $code)
                    ->where('user_id', '=', $user->id)
                    ->where('ex_at', '>', now())->first();
            }

            if ($res != null) {

                $oldtoken = $res->processe_token->first();
                $expired_at = date_create($oldtoken->expired_at);
                $dif = now()->isAfter($expired_at);
                $comper = Hash::check($token, $oldtoken->token);

                $token_status = !$dif && $comper;
                if ($token_status) {
                    $user->forceFill([
                        'password' => Hash::make($args['password']),
                    ])->save();
                    event(new PasswordReset($user));


                    $res->processe_token()->delete();
                    $res->ex_at = now();


                    foreach ($user->tokens as $token) {

                        $tokenRepository = app(TokenRepository::class);
                        $refreshTokenRepository = app(RefreshTokenRepository::class);
                        $tokenRepository->revokeAccessToken($token->id);
                        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
                    }

                    return [

                        "responInfo" => [
                            'state' => true,
                            'message' => "تم تغيير كلمة المرور بنجاح "."\n"." يمكنك الان تسجيل الدخول ب استخدام كلمة المرور الجديدة ",
                            'errors' => null,
                            'code' => 200,
                        ],
                        'token' => $user->createToken($args["tokenname"] ?? "newToken" . request()->ip())->accessToken
                    ];
                } else {


                    return [

                        "responInfo" => [
                            'state' => false,
                            'message' => 'عذرا\n انتهت صلاحة الكود الرجاء اعادة ارسال الكود',
                            'errors' => null,
                            'code' => 500,
                        ],
                        'token' => null
                    ];
                }
            }


            else {
                return [

                    "responInfo" =>
                     [
                        'state' => false,
                        'message' => 'عذرا\n انتهت صلاحية الكود الرجاء اعادة ارسال الكود',
                        'errors' => null,
                        'code' => 500,
                    ],
                    'token' => null
                ];
            }

        }catch(Exception $e){
            return [

                "responInfo" => [
                    'state' => false,
                    'message' =>
                    $e->getMessage(),
                    'errors' => null,
                    'code' => 500,
                ],
                'token' => null
            ];
        }
    }
}
