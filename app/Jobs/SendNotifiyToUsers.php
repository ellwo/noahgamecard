<?php

namespace App\Jobs;

use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\FirebaseToken;
use Exception;
//use Kreait\Firebase\Messaging\AndroidConfig;
// use NotificationChannels\Fcm\FcmMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

class SendNotifiyToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected UserNotification  $userNotification;
     protected $notification;

    public function __construct(UserNotification $userNotification)
    {
        //

        $this->userNotification=$userNotification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->sendFMC($this->userNotification);

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
        $notification = array(
            'title' => $userNotification->title,
            'body' => $userNotification->body,
            'image' => $userNotification->img ?? '',
            'icon' => 'https://backendapi.noahgamecard.com//images/64beac562b9ae1690217558.png',
            'sound' => 'default',
            'badge' => '1',
        );
        // $config = AndroidConfig::fromArray([
        //     'ttl' => '3600s',
        //     'priority' => 'normal',
        //     'notification' => [
        //         'title' => '$GOOG up 1.43% on the day',
        //         'body' => '$GOOG gained 11.80 points to close at 835.67, up 1.43% on the day.',
        //         'icon' => 'https://backendapi.noahgamecard.com//images/64beac562b9ae1690217558.png',
        //         'color' => '#f45342',
        //         'sound' => 'default',
        //     ],
        // ]);
        // $r=FcmMessage::create()
        // ->setData($dataArr)
        // ->setToken($userNotification->user->f_token->pluck('token')->first())
        // ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
        //     ->setTitle($notification['title'])
        //     ->setBody($notification['body'])
        //     ->setImage($notification['img']??""));


        //$r= $FcmToken = auth()->user()->fcm_token;
        $title = $notification['title'];
        $body = $notification['body'];
        $message = CloudMessage::fromArray([
            //   'token' => $userNotification->user->f_token()->orderBy('id','desc')->pluck('token')->first(),
            'notification' => $notification,
            'data' => $dataArr
        ]);
        //->withAndroidConfig($config);

        try {
            $r = $this->notification->sendMulticast($message, $userNotification->user->f_token()->orderBy('id', 'desc')->pluck('token')->toArray());

            $successfulTargets = $r->validTokens(); // string[]
            $unknownTargets = $r->unknownTokens(); // string[]

            FirebaseToken::whereIn('token', $unknownTargets)->delete();
            // Invalid (=malformed) tokens
            $invalidTargets = $r->invalidTokens();
            FirebaseToken::whereIn('token', $invalidTargets)->delete();

            $userNotification->update([
                'sented' => true
            ]);
        } catch (Exception $e) {
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

}
