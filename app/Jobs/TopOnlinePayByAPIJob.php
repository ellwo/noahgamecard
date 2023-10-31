<?php

namespace App\Jobs;

use App\Models\AdminNotify;
use App\Models\ClientProvider;
use App\Models\Paymentinfo;
use App\Models\PaymentinfoExecuteBy;
use App\Models\RassedActevity;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TopOnlinePayByAPIJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public Paymentinfo $paymentinfo;
    public RassedActevity $rassedActevity;
    public $userid = 17577;
    public $mobile = "777777777";
    public $username = "777777777";
    public $password = "Asd777777777";
    public $pay_url = 'https://toponline.yemoney.net/api/yr/gameswcards';
    public $chack_url = 'https://toponline.yemoney.net/api/yr/info';

    public function __construct(RassedActevity $rassedActevity)
    {
        $this->rassedActevity = $rassedActevity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->rassedActevity->paymentinfo->orders->count() > 0) {
            $product = $this->rassedActevity->paymentinfo->order->product;

            if ($product->provider_product->count() > 0) {

                $clientProvider = $product->provider_product()->first()->client_provider;

                if ($clientProvider->id == 1) {

                    // $this->paymentinfo=$this->rassedActevity->paymentinfo;


                    $this->paymentinfo = $this->rassedActevity->paymentinfo;
                    $this->handle_process();
                    //dispatch(new TopOnlinePayByAPIJob($this->rassedActevity->paymentinfo));
                }
            }
        }
    }

    public function handle_process()
    {


        $queryParams = $this->getParametres(); //Fileds
        $transid = $this->paymentinfo->id; //TransID
        $queryParams['token'] = $this->genurateToken($transid); //Token
        $queryParams['transid'] = $transid; //
        $queryParams['userid'] = $this->userid;
        $queryParams['mobile'] = $this->mobile;
        // $queryParams['uniqcode']="63";


        try {

            $response = Http::get($this->pay_url, $queryParams);
        } catch (Exception  $e) {

            throw $e;
            return;
        }

        Log::channel('top_online')->info($response);
        Log::channel('top_online')->info($queryParams);
        // Log::channel('top_online')->info($response->json());

        //       return dd($response);
        $result = $response->json(); // it's null

        if ($response->json() == null || $response->status() == 404) {
            AdminNotify::create([
                'title' => 'لم يستطع الاتصال بالمزود Toponline',
                'body' => " يرجى التأكد من المزود نفسه توب اونلاين",
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);
        } else if ($response->json('resultCode') == "1008") {
            AdminNotify::create([
                'title' => 'لم يستطع الاتصال بالمزود Toponline',
                'body' => " يرجى التأكد من صحة معلومات الاتصال (اسم المستخدم,كلمة المرور وبقية التفاصيل)",
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);

            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ');
        } else if ($response->json('resultCode') == "1658" && $response->json('remainAmount') != null) {
            $body = "اجمالي العملية " . $this->paymentinfo->total_price . "\n" . "رصيدك الحالي " . $response->json('remainAmount') . " ريال يمني ";
            AdminNotify::create([
                'title' => 'رصيدك غير لدى توب اونلاين كافي لتنفيذ عملية ',
                'body' => $body,
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);

            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ');
        } else if ($response->json('resultCode') == "1658") {
            AdminNotify::create([
                'title' => '  الفئة غير متوفرة Toponline',
                'body' => $response->json('resultDesc'),
                'link' => route('provider_products.edit', $this->paymentinfo->order->product->provider_product()->first()->id)
            ]);

            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ');
        } else if ($response->json('resultCode') == "1220") {


            $this->updatePay(3,'Id الحساب غير صحيح يرجى التأكد من صحته ');
        } else {





            if ($this->paymentinfo->order->product->provider_product()->first()->direct) {

                sleep(1);



                try {

                    $check = $this->chack_state($transid);

                    //Log::useFiles(storage_path().'/logs/top_online_log.log');
                    Log::channel('top_online')->info($check);
                    // Log::channel('top_online')->info($check->json());

                    // Log::log(0,'',);
                } catch (Exception $e) {
                    throw $e;
                }


                if ($check->json() == null || $check->status() == 404) {
                    AdminNotify::create([
                        'title' => "تم ارسال طلب ولم يستطع التحقق من حالتها",
                        'body' => 'يرجى التواصل مع المزود توب اونلاين , ومعالجة العملية يدويا '
                    ]);
                } else {

                    $check = $check->json();

                    $i = 0;
                    while ($check['isBan'] == 0 && $check['isDone']==0)  {
                        try {

                            $check = $this->chack_state($transid)->json();
                        } catch (Exception $e) {
                            throw $e;
                        }
                        $i++;
                    }





                    if ($check['resultCode'] == "0" && $check['isDone'] == 1) {
                        // اذا الرصيد نقص معناته انه نجحت العملية
                        $state = 2;

                        $body = "المنتج :  " . $this->paymentinfo->order->product->name;
                        $body .= "\n";
                        $body .= "السعر : " . $this->paymentinfo->orginal_total;
                        $body .= "\n";
                        $body .= "العميل : " . $this->paymentinfo->user->name;


                        AdminNotify::create([
                            'title' => 'عملية تم تنفيذها بواسطة TopOnline  ',
                            'body' => $body,
                            'link' => route('paymentinfo.show', $this->paymentinfo)
                        ]);

                        // "Player Name"
                        $error_note = $check['note'];

                    } else {
                        //مالم معناته فشل الطلب بسبب ان الايدي خطاء
                        $state = 3;



                        $body = "المنتج :  " . $this->paymentinfo->order->product->name;
                        $body .= "\n";
                        $body .= "السعر : " . $this->paymentinfo->orginal_total;
                        $body .= "\n";
                        $body .= "العميل : " . $this->paymentinfo->user->name;
                        $body .= "\n";
                        $body .= "عدد المحاولات  : " . $i;
                        AdminNotify::create([
                            'title' => 'عملية تم رفضها بواسطة TopOnline  ',
                            'body' => $body,
                            'link' => route('paymentinfo.show', $this->paymentinfo)
                        ]);
                        if (Str::contains($check['reason'], 'Invalid Player ID'))
                            $error_note = "ID اللاعب غير صحيح يرجى التحقق من صحة الاي دي.";
                        else
                            $error_note = "ID اللاعب غير صحيح يرجى التحقق من صحة الاي دي.";
                    }

                    // $this->paymentinfo->update([
                    //     'state' => $state,
                    //     'note' => $error_note
                    // ]);
                    $this->updatePay($state,$error_note);

                }
            } else {

                CheckTopOnlineProssce::dispatch($this->paymentinfo, $transid)->onQueue('hourly');
            }
            //هنا اذا قال لي جاري المعالجة هنا ارجع افحص العملية هل نجحت او لا  ..
            // $check = $this->chack_state($transid);
            // if ($check['resultCode']=="0" && $check['isDone']==1) {
            //     // اذا الرصيد نقص معناته انه نجحت العملية
            //     $state = 2;

            //     $error_note = "تم تنفيذ العملية بنجاح";
            // } else {
            //     //مالم معناته فشل الطلب بسبب ان الايدي خطاء
            //     $state = 3;
            //     $error_note = $check['reason'];
            // }

            // // $this->paymentinfo->update([
            // //     'state' => $state,
            // //     'note' => $error_note
            // // ]);

            // $pay=Paymentinfo::find($this->paymentinfo->id);
            // $pay->state=$state;
            // $pay->note=$error_note;

            // $product = $this->paymentinfo->order->product;
            // $clientProvider = $product->provider_product()->first()->client_provider;

            // $byh = PaymentinfoExecuteBy::create([
            //     'paymentinfo_id' => $this->paymentinfo->id,
            //     'state' => $state,
            //     'execute_type' => ClientProvider::class,
            //     'execute_id' => $clientProvider->id,
            //     'note' => $error_note
            // ]);
            // $this->paymentinfo->excuted_status()->save($byh);
            // $pay->save();

        }
    }



    function updatePay($state,$error_note) {

        $pay = Paymentinfo::find($this->paymentinfo->id);
        $pay->state = $state;
        $pay->note = $error_note;
        $pay->save();
        $product = $this->paymentinfo->order->product;
        $clientProvider = $product->provider_product()->first()->client_provider;

        $byh = PaymentinfoExecuteBy::create([
            'paymentinfo_id' => $this->paymentinfo->id,
            'state' => $state,
            'execute_type' => ClientProvider::class,
            'execute_id' => $clientProvider->id,
            'note' => $error_note
        ]);
        $this->paymentinfo->excuted_status()->save($byh);
    }



    public function getParametres()
    {

        $order = $this->paymentinfo->order;
        // return dd($order->reqs);
        $reqs = $this->paymentinfo->order->product->provider_product()->first()->reqs;

        foreach ($order->reqs as $v) {
            $value = $v['value'];


            $i = 0;

            foreach ($reqs as $r) {
                if ($r['lable'] == $v['lable']) {
                    $reqs[$i]['val'] = $value;
                }
                $i++;
            }
        }





        $query = "";
        $qq = [];
        foreach ($reqs as $r) {
            $query .= $r['name'] . "=" . $r['val'] . "&";
            $qq[$r['name']] = $r['val'];
        }


        return $qq;
        # code...
    }


    function genurateToken($transid)
    {
        $hashPassword = md5($this->password);
        $token = md5($hashPassword . $transid . $this->username . $this->mobile);
        return $token;
    }



    function chack_state($transid)
    {
        $url = $this->chack_url;
        $paras = [
            'transid' => $transid,
            'token' => $this->genurateToken($transid),
            'userid' => $this->userid,
            'mobile' => $this->mobile,
            'action' => 'status'
        ];
        try {
            $response = Http::get($url, $paras);
        } catch (Exception  $e) {

            throw $e;
            return;
        }

        return $response;
    }

    /**

        $queryParams = $this->getParametres();//Fileds
        $transid = rand(1, 485);//TransID
        $queryParams['token'] = $this->genurateToken($transid);//Token
        $queryParams['transid'] = $transid;//
        $queryParams['userid'] = $this->userid;
        $queryParams['mobile']=$this->mobile;
        $response = Http::get($this->pay_url, $queryParams);
        //       return dd($response);
        $result = $response->json(); // it's null

        if ($response->json('resultCode') == "1008") {
            AdminNotify::create([
                'title' => 'لم يستطع الاتصال بالمزود Toponline',
                'body' => " يرجى التأكد من صحة معلومات الاتصال (اسم المستخدم,كلمة المرور وبقية التفاصيل)",
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);
        } else if ($response->json('resultCode') == "1658" && $response->json('remainAmount') != null) {
            $body = "اجمالي العملية " . $this->paymentinfo->total_price . "\n" . "رصيدك الحالي " . $response->json('remainAmount') . " ريال يمني ";
            AdminNotify::create([
                'title' => 'رصيدك غير لدى توب اونلاين كافي لتنفيذ عملية ',
                'body' => $body,
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);
        } else if ($response->json('resultCode') == "1220") {
            $product = $this->paymentinfo->order->product;
            $clientProvider = $product->provider_product()->first()->client_provider;

            $byh = PaymentinfoExecuteBy::create([
                'paymentinfo_id' => $this->paymentinfo->id,
                'state' => 3,
                'execute_type' => ClientProvider::class,
                'execute_id' => $clientProvider->id,
                'note' => "فشل الطلب ID اللاعب غير صحيح"
            ]);
            $this->paymentinfo->excuted_status()->save($byh);

            // $this->paymentinfo->update([
            //     'state' => 3,
            //     'note' => "ID اللاعب غير صحيح "
            // ]);
            $pay=Paymentinfo::find($this->paymentinfo->id);
            $pay->state=3;
            $pay->note="ID اللاعب غير صحيح ";
            $pay->save();

        } else {

            //هنا اذا قال لي جاري المعالجة هنا ارجع افحص العملية هل نجحت او لا  ..
            $check = $this->chack_state($transid);
            if ($check['isDone']) {
                // اذا الرصيد نقص معناته انه نجحت العملية
                $state = 2;

                $error_note = "تم تنفيذ العملية بنجاح";
            } else {
                //مالم معناته فشل الطلب بسبب ان الايدي خطاء
                $state = 3;
                $error_note = $check['resultDesc'];
            }

            // $this->paymentinfo->update([
            //     'state' => $state,
            //     'note' => $error_note
            // ]);

            $pay=Paymentinfo::find($this->paymentinfo->id);
            $pay->state=$state;
            $pay->note=$error_note;
            $pay->save();

            $product = $this->paymentinfo->order->product;
            $clientProvider = $product->provider_product()->first()->client_provider;

            $byh = PaymentinfoExecuteBy::create([
                'paymentinfo_id' => $this->paymentinfo->id,
                'state' => $state,
                'execute_type' => ClientProvider::class,
                'execute_id' => $clientProvider->id,
                'note' => $error_note
            ]);
            $this->paymentinfo->excuted_status()->save($byh);

             public function getParametres()
    {

        $order = $this->paymentinfo->order;
        // return dd($order->reqs);
        $reqs = $this->paymentinfo->order->product->provider_product()->first()->reqs;

        foreach ($order->reqs as $v) {
            $value = $v['value'];


            $i = 0;

            foreach ($reqs as $r) {
                if ($r['lable'] == $v['lable']) {
                    $reqs[$i]['val'] = $value;
                }
                $i++;
            }
        }





        $query = "";
        $qq = [];
        foreach ($reqs as $r) {
            $query .= $r['name'] . "=" . $r['val'] . "&";
            $qq[$r['name']] = $r['val'];
        }


        return $qq;
        # code...
    }


    function genurateToken($transid)
    {
        $hashPassword = md5($this->password);
        $token = md5($hashPassword . $transid . $this->username . $this->mobile);
        return $token;
    }

    function chack_state($transid)
    {
        $url = $this->chack_url;
        $paras = [
            'transid' => $transid,
            'token' => $this->genurateToken($transid),
            'userid' => $this->userid,
            'mobile' => $this->mobile,
            'action' => 'status'
        ];
        $response = Http::get($url, $paras);

        $res = $response->json();

        return $res;
    }
        } */
}
