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

        return    $this->byEmail($args);





    }

    function byEmail($args) {



        try{
        $user=User::where($args["type"],'=',$args["value"])->first();
        if($user!=null){


            $hasCode= $res=PhoneCode::where('phone','=',$args['value'])
            ->where('ex_at','>',now())->get();

            if(count($hasCode)>1){
                foreach ($hasCode as $c) {
                    $c->update([
                        'ex_at'=> now()
                    ]);
                    # code...
                }
            }

            // if(count($hasCode??[])>=3){

            // return [
            //     'state'=>true,
            //     'message'=>'لم يتم ارسال كود جديد ولكن تم ارسال كود من قبل يمكنك اسنخدامه',
            //     'errors'=>null,
            //     'code'=>200
            // ];

            // }




            $date=new DateTime('now');
            $date->modify('+59 minutes');
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
