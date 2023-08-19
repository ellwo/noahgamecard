<?php

namespace App\GraphQL\Mutations;

use App\Models\PhoneCode;
use App\Models\User;
use App\Notifications\CustomPasswordCodeNotification;
use DateTime;
use Exception;

final class RequstRestoreAccountCode
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver





        return    $this->byEmail($args);





    }

    function byEmail($args) {



        try{
        $user=User::where($args["type"],'=',$args["value"])->first();
        if($user!=null){
            $hasCode= $res=PhoneCode::where('phone','=',$args['value'])
            ->where('ex_at','>',now())->get();

            if(count($hasCode??[])>=3){


            return [
                'state'=>true,
                'message'=>'لم يتم ارسال كود جديد ولكن تم ارسال كود من قبل يمكنك اسنخدامه',
                'errors'=>null,
                'code'=>200
            ];

            }



            //$res=PhoneCode::where('phone','=',$args['value'])
           // ->where('ex_at','>',now())->delete();
            // TODO implement the resolver
            $date=new DateTime('now');
            $date->modify('+59 minutes');

           // rand(rand(rand(14465,66899742),24598550566),8795668442)
         //   $codee=rand(rand(rand(1456165465,66899545742),245554598550),879554668442)."";
            $codee=rand(rand(14465,24598550),87952)."";
            //  $strln=strlen($codee);

            $fcodee=substr($codee,0,4);
            $code=PhoneCode::create([
                'phone'=>$args["value"],
                "code"=>$fcodee,
                "ex_at"=>$date,
                'user_id'=>$user->id
            ]);




            if($args['type']=="phone"){
                // Send SMS Code

            return [
                'state'=>true,
                'message'=>'تم ارسال الكود بنجاح',
                'errors'=>null,
                'code'=>200
            ];
            }
            else{



                try{
                $user->notify(new CustomPasswordCodeNotification($fcodee));

            return [
                'state'=>true,
                'message'=>'تم ارسال الكود بنجاح',
                'errors'=>null,
                'code'=>200
            ];
                }
                catch(Exception $e){

                    $code->delete();

            return [
                'state'=>false,
                'message'=>"لايمكن الاتصال بالسرفر حاليا يرجى اعادة المحاولة لاحقا ",
                'errors'=>null,
                'code'=>500
            ];

                }
                //Send Email Code
                // (new MailMessage)
                // ->subject(Lang::get('Reset Password Notification'))
                // ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
                // ->action(Lang::get('Reset Password'), $url)
                // ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                // ->line(Lang::get('If you did not request a password reset, no further action is required.'));

            }



        }
        else{

            return [
                'state'=>false,
                'message'=>"هذا المستخدم غير موجود ",
                'errors'=>null,
                'code'=>500
            ];
        }
    }catch(Exception $e){

        return [
            "state"=>false,
            "message"=>$e->getMessage(),
            "errors"=>null,
            "code"=>500,

        ];
    }



    }
}
