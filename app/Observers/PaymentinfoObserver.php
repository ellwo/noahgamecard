<?php

namespace App\Observers;

use App\Models\Paymentinfo;
use App\Models\UserNotification;

class PaymentinfoObserver
{
    /**
     * Handle the Paymentinfo "created" event.
     *
     * @param  \App\Models\Paymentinfo  $paymentinfo
     * @return void
     */
    public function created(Paymentinfo $paymentinfo)
    {

        //
    }

    /**
     * Handle the Paymentinfo "updated" event.
     *
     * @param  \App\Models\Paymentinfo  $paymentinfo
     * @return void
     */
    public function updated(Paymentinfo $paymentinfo)
    {
        //



        if(($paymentinfo->state==2 || $paymentinfo->state==3) && $paymentinfo->orders->count()>0){
        $data=[
            "type"=>"paymentinfo",
            "routeInfo"=>[
                "routeName"=>"paymentinforeceiptscreen",
                "data"=>$paymentinfo,
            ],
        ];
        UserNotification::create([
            'title'=>($paymentinfo->state==2?'  نجاح تم تنفيذ الطلب ':' فشل الطلب   ')." رقم  ".$paymentinfo->id,
            'body'=>$paymentinfo->state==2?'تم شحن البطائق المطلوبة بنجاح يرجى مراجعة حسابك':' عذرا فشلت العملية وذلك بسبب  '.$paymentinfo->note,
            'user_id'=>$paymentinfo->user_id,
            'data'=>$data
        ]);
    }
    else if(($paymentinfo->state>0 || $paymentinfo->state==3) && $paymentinfo->rassed_actevity!=null){

     $data=[
            "type"=>"veed_rassed",
            "routeInfo"=>[
                "routeName"=>"rassed",
                "data"=>$paymentinfo,
            ],
          ];
        UserNotification::create([
            'title'=>(($paymentinfo->state==2||$paymentinfo->state==1)?'تم تأكيد تغذية حسابك':' عذرا فشلت عملية التغذية    ')." رقم العملية  ".$paymentinfo->id,
            'body'=>($paymentinfo->state==2||$paymentinfo->state==1)?"تم تغذية رصيدك بنجاح يرجى مراجعة حسابك  مبلغ \n".$paymentinfo->rassed_actevity->amount :' عذرا فشلت عملية التغذية وذلك بسبب  '.$paymentinfo->note,
            'user_id'=>$paymentinfo->user_id,
            'data'=>$data
        ]);
    }
    }

    /**
     * Handle the Paymentinfo "deleted" event.
     *
     * @param  \App\Models\Paymentinfo  $paymentinfo
     * @return void
     */
    public function deleted(Paymentinfo $paymentinfo)
    {
        //
    }

    /**
     * Handle the Paymentinfo "restored" event.
     *
     * @param  \App\Models\Paymentinfo  $paymentinfo
     * @return void
     */
    public function restored(Paymentinfo $paymentinfo)
    {
        //
    }

    /**
     * Handle the Paymentinfo "force deleted" event.
     *
     * @param  \App\Models\Paymentinfo  $paymentinfo
     * @return void
     */
    public function forceDeleted(Paymentinfo $paymentinfo)
    {
        //
    }
}
