<?php

namespace App\Observers;

use App\Jobs\SendNotifiyToUsers;
use App\Models\FirebaseToken;
use App\Models\UserNotification;
use Exception;
use Kreait\Firebase\Messaging\AndroidConfig;
// use NotificationChannels\Fcm\FcmMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class UserNotificationObserver
{
    /**
     * Handle the UserNotification "created" event.
     *
     * @param  \App\Models\UserNotification  $userNotification
     * @return void
     */
    protected $notification;
    public function created(UserNotification $userNotification)
    {

        //$userNotification->data["created_at"]=$userNotification->created_at;
        //$userNotification->save();
        $this->sendFMC($userNotification);
        // SendNotifiyToUsers::dispatch($userNotification);
    //    dispatch(new SendNotifiyToUsers($userNotification));
    }

    function sendFMC($userNotification)
    {

        $this->notification = Firebase::messaging();
        //$url = 'https://fcm.googleapis.com/fcm/send';

        $dataArr = array(
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'id' => $userNotification->id . "",
            "data" => $userNotification->data,
            'status' => "done",
            'created_at' => date('Y/m/d H:i:s')
        );
        $notification =array(
            'title' => $userNotification->title,
            'body' => $userNotification->body,
            'image' => $userNotification->img ?? '',
            'sound'=>'default'
            );
        $config = AndroidConfig::fromArray([
            'ttl' => '3600s',
            'priority' => 'high',
            'notification' => [
                'title' => $userNotification->title,
                'body' => $userNotification->body,
                'icon' => 'https://backendapi.noahgamecard.com//images/64beac562b9ae1690217558.png',
                'color' => '#f45342',
                'sound' => 'default',
            ],
        ]);
        // $r=FcmMessage::create()
        // ->setData($dataArr)
        // ->setToken($userNotification->user->f_token->pluck('token')->first())
        // ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
        //     ->setTitle($notification['title'])
        //     ->setBody($notification['body'])
        //     ->setImage($notification['img']??""));


        //$r= $FcmToken = auth()->user()->fcm_token;
        // $title = $notification['title'];
        // $body = $notification['body'];
        $message = CloudMessage::fromArray([
             'token' => $userNotification->user->f_token()->orderBy('id','desc')->pluck('token')->first(),
            'notification' => $notification,
            'data' => $dataArr
        ])->withDefaultSounds()->withAndroidConfig($config)->withHighestPossiblePriority();

        try {
            // $r=$this->notification->send($message);

            // return dd($r);
            $r = $this->notification->sendMulticast($message, $userNotification->user->f_token()->orderBy('updated_at', 'desc')->pluck('token')->toArray());

            $successfulTargets = $r->validTokens(); // string[]
            $unknownTargets = $r->unknownTokens(); // string[]

            FirebaseToken::whereIn('token', $unknownTargets)->delete();
            // Invalid (=malformed) tokens
            $invalidTargets = $r->invalidTokens();
            FirebaseToken::whereIn('token', $invalidTargets)->delete();

            $userNotification->update([
                'sented' => true
            ]);

            // return dd($r);
        } catch (Exception $e) {

            // return dd($e);
        }

        // $fields = json_encode ($arrayToSend);
        // $headers = array (
        //     'Authorization: key=' . config('firebase.server_key'),
        //     'Content-Type: application/json'
        // );

        // $ch = curl_init ();
        // curl_setopt ( $ch, CURLOPT_URL, $url );
        // curl_setopt ( $ch, CURLOPT_POST, true );
        // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        // curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        // $result =
        //  curl_exec ( $ch );
        // curl_close ( $ch );


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
