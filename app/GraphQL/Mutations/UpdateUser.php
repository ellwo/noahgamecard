<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

final class UpdateUser
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver



        $user=User::find(auth()->user()->id);

        if($user->email !=$args['input']['email']){
            $emailroles[]=['required','email','unique:users,email'];
        }
        else
        $emailroles[]=['required','email'];


        // if($user->phone !=$args['input']['phone']){
        //     $phoneroles[]=['required','unique:users,phone','starts_with:73,77,78,71,70','min:9','max:9'];
        // }
        // else
        // $phoneroles[]=['required','starts_with:73,77,78,71,70','min:9','max:9'];

        if($user->username!=$args['input']['username']){
            $userRole=['min:4','regex:/^[a-z\d_.]{2,20}$/i','required','string', 'max:191', 'unique:users,username'];
        }
        else
        $userRole=['min:4','regex:/^[a-z\d_.]{2,20}$/i','required','string', 'max:191',];




        $vildat = Validator::make(
            $args["input"],
           [
            'name'=>"required",
            'email'=>$emailroles,
            'username' =>$userRole,
           ],[
            'username.unique'=>'اسم المستخدم موجود بالفعل'
           ]
         );

         if($vildat->fails()){

            return [
                'responInfo'=>[
                    "state"=>false,
                    "message"=>"فشلت العملية الرجاء التحقق من صحة المعلومات المدخلة",
                    "errors"=>json_encode($vildat->errors()),
                    'code'=>400
                ],
                'user'=>null
                ];

         }
         else{

            $inputs=$args['input'];
            $user->update([
                'name'=>$inputs['name'],
                'email'=>$inputs['email'],
                'username'=>$inputs['username']
            ]);

            return [
                'responInfo'=>[
                    "state"=>true,
                    "message"=>"تم تعديل البيانات بنجاح",
                    "errors"=>null,
                    'code'=>200
                ],
                'user'=>$user
                ];



         }
    }
}
