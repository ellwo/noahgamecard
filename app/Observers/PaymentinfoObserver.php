<?php

namespace App\Observers;

use App\Jobs\TopOnlinePayByAPIJob;
use App\Models\Paymentinfo;
use App\Models\PaymentinfoExecuteBy;
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



        if (($paymentinfo->state == 2 || $paymentinfo->state == 3) && $paymentinfo->orders->count() > 0) {
            $data = [
                "type" => "paymentinfo",
                "routeInfo" => [
                    "routeName" => "paymentinforeceiptscreen",
                    "data" => $paymentinfo,
                ],
                "created_at" => date('Y/m/d H:i:s'),
                'total_price' => $paymentinfo->total_price
            ];
            $order = $paymentinfo->orders[0];
            $body = $order->product->name . " عدد /:" . $order->qun;

            foreach ($order->reqs as $value) {
                # code.
                if ($value['value'] != null) {
                    $body .= "\n  ";
                    $body .= $value['lable'] . " : " . $value['value'];
                }
            }



            UserNotification::create([
                'title' => ($paymentinfo->state == 2 ? '  نجاح تم تنفيذ الطلب ' : ' فشل الطلب   ') . " رقم  " . $paymentinfo->id,
                'body' => $paymentinfo->state == 2 ? $body : $body . "\n عذرا فشلت العملية وذلك بسبب  \n" . $paymentinfo->note,
                'user_id' => $paymentinfo->user_id,
                'data' => $data
            ]);


            if($paymentinfo->state==2){

                $paymentinfo->rassed_actevity->update([
                    'amount' => -$paymentinfo->total_price
                ]);
            }


        } else if (($paymentinfo->state > 0 || $paymentinfo->state == 3) &&
            $paymentinfo->order == null) {

            $data = [
                "type" => "veed_rassed",
                "routeInfo" => [
                    "routeName" => "rassed",
                    "data" => $paymentinfo,
                    "rassed_act"=>$paymentinfo->rassed_actevity
                ],
                "created_at" => date('Y/m/d H:i:s')
            ];
            UserNotification::create([
                'title' => (($paymentinfo->state == 2 || $paymentinfo->state == 1) ? 'تم تأكيد تغذية حسابك' : ' عذرا فشلت عملية التغذية    ') . " رقم العملية  " . $paymentinfo->id,
                'body' => ($paymentinfo->state == 2 || $paymentinfo->state == 1) ? "تم تغذية رصيدك بنجاح يرجى مراجعة حسابك  مبلغ \n" . $paymentinfo->orginal_total : ' عذرا فشلت عملية التغذية وذلك بسبب  ' . $paymentinfo->note,
                'user_id' => $paymentinfo->user_id,
                'data' => $data
            ]);
        }
        if ($paymentinfo->state == 3 && $paymentinfo->rassed_actevity != null) {

            $paymentinfo->rassed_actevity->update([
                'amount' => 0
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
