<?php

namespace App\GraphQL\Mutations;

use App\Models\PhoneCode;
use App\Models\User;
use DateTime;

final class RestoreAccount
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver



        if($args["type"]=="email"){

            $this->byEmail($args);
        }




    }

    function byEmail($args) {


        $user=User::where($args["type"],'=',$args["value"])->first();
        if($user!=null){
            $hasCode= $res=PhoneCode::where('phone','=',$args['value'])
            ->where('ex_at','>',now())->get();

            if(count($hasCode??[])>=3){


            return [
                'state'=>false,
                'message'=>' عذرا \nتخطيت الحد المسموح لطلب الكود يرجى اعادة المحاولة لاحقا',
                'errors'=>null,
                'code'=>401
            ];

            }



            $res=PhoneCode::where('phone','=',$args['value'])
            ->where('ex_at','>',now())->delete();
            // TODO implement the resolver
            $date=new DateTime('now');
            $date->modify('+59 minutes');
            $codee=rand(rand(rand(14465,66899742),24598550),8795668442)."";
           $strln=strlen($codee);

            $fcodee=substr($codee,rand(rand(0,$strln),$strln-1),4);
            $code=PhoneCode::create([
                'phone'=>$args["value"],
                "code"=>$fcodee,
                "ex_at"=>$date,
                'user_id'=>$user->id
            ]);




            if($args['type']=="phone"){
                // Send SMS Code
            }
            else{
                //Send Email Code
                // (new MailMessage)
                // ->subject(Lang::get('Reset Password Notification'))
                // ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
                // ->action(Lang::get('Reset Password'), $url)
                // ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                // ->line(Lang::get('If you did not request a password reset, no further action is required.'));

            }


            return [
                'state'=>true,
                'message'=>'تم ارسال الكود بنجاح',
                'errors'=>null,
                'code'=>200
            ];

        }



    }
}
