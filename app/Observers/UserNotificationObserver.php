<?php

namespace App\Observers;

use App\Models\UserNotification;
use Exception;

class UserNotificationObserver
{
    /**
     * Handle the UserNotification "created" event.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return void
     */
    public function created(UserNotification $userNotification)
    {

        //$userNotification->data["created_at"]=$userNotification->created_at;
        //$userNotification->save();
        $this->send($userNotification);
    }

    function send($userNotification){


        $url = 'https://fcm.googleapis.com/fcm/send';

        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK',
         'id' => $userNotification->id,
         "data"=>$userNotification->data,
         'status'=>"done",);
        $notification = array(
        'title' =>$userNotification->title,
        'body' => $userNotification->body,
        'image'=> $userNotification->img??'',
        'sound' => 'default',
        'badge' => '1',);
        $arrayToSend = array(
        'registration_ids' => $userNotification->user->f_token->pluck('token')->toArray(),
        'notification' => $notification,
        'data' => $dataArr,
        'priority'=>'high');

        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: key=' . config('firebase.server_key'),
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result =
         curl_exec ( $ch );

         var_dump($result);
        curl_close ( $ch );

    //     try{

    //     if($result!=false)
    //     {
    //         $userNotification->update([
    //             'sented'=>true
    //         ]);
    //     }

    //     return dd($result);

    // }catch (Exception $e){
    //     return dd(["ex"=>$e,
    // "result"=>$result]);

    // }


    }


    /**
     * Handle the UserNotification "updated" event.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return void
     */
    public function updated(UserNotification $userNotification)
    {
        //
    }

    /**
     * Handle the UserNotification "deleted" event.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return void
     */
    public function deleted(UserNotification $userNotification)
    {
        //
    }

    /**
     * Handle the UserNotification "restored" event.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return void
     */
    public function restored(UserNotification $userNotification)
    {
        //
    }

    /**
     * Handle the UserNotification "force deleted" event.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return void
     */
    public function forceDeleted(UserNotification $userNotification)
    {
        //
    }
}
