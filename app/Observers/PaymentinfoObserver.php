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
            'user_id'=>$paymentinfo->orders()->first()->user->id,
            'data'=>$data
        ]);

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
