<?php

namespace App\GraphQL\Mutations;

use App\Models\Coin;
use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\RassedActevity;
use App\Models\User;
use App\Models\UserNotification;
use Exception;
use Illuminate\Support\Facades\Validator;

final class Veedmyrassed
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver



        $vildat = Validator::make(
            $args['input'],
            [
                'code' => ['unique:paymentinfos,code', 'required', 'min:6', 'max:10'],
                'paymentmethod_id' => ['required', 'exists:paymentmethods,id'],
                "camount"=>['required'],
                "coin_id"=>['required','exists:coins,id']
            ],
            [
                'code.unique' => 'هذا الكود مستخدم بالفعل ',
                'code.min' => 'يجب ان يكون الكود 6 ارقام على الاقل',
                'code.max' => 'يجب ان يكون الكود 11 ارقام على الاكثر',
                'code.required' => 'يجب ادخال الكود',
                'camount.*'=>'يجب ادخال المبلغ الذي تم تحويله ',
            ]
        );

        if ($vildat->fails()) {

            return [
                'state' => false,
                'errors' => json_encode($vildat->errors()),
                'message' => "لديك اخطاء في البيانات المدخلة",
                'paymetninfo' => null,
                'code' => 402
            ];
        }
        else{
        try {









            $user = User::find(auth()->user()->id);

            $rassed = $user->rassed;
            $paymentmethod = Paymentmethod::find($args["input"]["paymentmethod_id"]);
            $payinfo = Paymentinfo::create([
                "paymentmethod_id" => $paymentmethod->id,
                "code" => $args["input"]["code"],
                "state" => 0,
                'user_id'=>$user->id,
                'coin_id' => $args['input']['coin_id']
            ]);
            //    $camount=
            $ra = RassedActevity::create([
                'amount' => 0,
                "paymentinfo_id" => $payinfo->id,
                "code" => $args["input"]["code"],
                "rassed_id" => $rassed->id,
                'camount' => $args['input']['camount'],
                'coin_id' => $args['input']['coin_id']
            ]);


            //    $noti=UserNotification::create([
            //     "id"=>$ra->id,
            //     'title'=>'نجحت العملية',
            //     'body'=>'تمت اضافة الرصيد'.$ra->amount.'$ بنجاح',
            // 'user_id'=>$user->id]);

            return [
                "state" => true,
                "message" => "تمت اضافة طلب تغذية الرصيد بنجاح",
                "errors" => null,
                "code" => 200,
                "paymentinfo" => $payinfo
            ];
        } catch (Exception $e) {

            return [
                "state" => false,
                "message" => $e->getMessage(),
                "errors" => $e->getMessage(),
                "code" => 501,
                "paymetninfo" => null,
            ];
        }
    }
    }


    function send($req, $user)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $dataArr = array(
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'id' => $req["id"] ?? 0,
            'status' => "done"
        );
        $notification = array(
            'title' => $req['title'] ?? "",
            'body' => $req['body'] ?? "",
            'image' => $req['img'] ?? "",
            'sound' => 'default',
            'badge' => '1',
        );
        $arrayToSend = array(
            'to' => $user->f_token->token,
            'notification' => $notification,
            'data' => $dataArr,
            'priority' => 'high'
        );

        $fields = json_encode($arrayToSend);
        $headers = array(
            'Authorization: key=' . config('firebase.server_key'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        //var_dump($result);
        curl_close($ch);
    }
}
