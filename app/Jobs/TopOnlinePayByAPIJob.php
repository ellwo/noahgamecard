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
    public $mobile = "778928008";
    public $username = "778928008";
    public $password = "Asd777777777";
    public $pay_url = 'https://toponline.yemoney.net/api/yr/gameswcards';
    public $chack_url = 'https://toponline.yemoney.net/api/yr/info';
    public $clientProvider = null;

    public function __construct(RassedActevity $rassedActevity)
    {


        $this->rassedActevity = $rassedActevity;

        if ($this->rassedActevity->paymentinfo->orders->count() > 0) {
            $product = $this->rassedActevity->paymentinfo->order->product;

            if ($product->provider_product->count() > 0) {

                $clientProvider = $product->provider_product()->first()->client_provider;

                if ($clientProvider!=null) {
                    $this->userid=$clientProvider->api_userid;
                    $this->mobile=$clientProvider->api_phone;
                    $this->password=$clientProvider->api_password;
                    $this->pay_url=$clientProvider->api_payurl;
                    $this->chack_url=$clientProvider->api_checkurl;
                    $this->username=$clientProvider->api_username;
                    $this->clientProvider = $clientProvider;
                    
                    # code...
                }

            }
        
        }
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

                //if ($clientProvider->id == 1) {


                    $this->paymentinfo = $this->rassedActevity->paymentinfo;
                    $this->handle_process();
                //}
            }
        }
    }

    public function handle_process()
    {


        $queryParams = $this->getParametres(); //Fileds
        $transid = $this->paymentinfo->id+100; //TransID
        $queryParams['token'] = $this->genurateToken($transid); //Token
        $queryParams['transid'] = $transid; //
        $queryParams['userid'] = $this->userid;
        $queryParams['mobile'] = $this->mobile;
        // $queryParams['uniqcode']="63";


        try {

            $response = Http::get($this->pay_url, $queryParams);

            Log::channel($this->clientProvider->name)->info("payinfo -- ------------------Start----------------------");
            Log::channel($this->clientProvider->name)->info($response);
            Log::channel($this->clientProvider->name)->info($queryParams);
            Log::channel($this->clientProvider->name)->info($this->paymentinfo->id);
            Log::channel($this->clientProvider->name)->info("pay ------------------------------End -------------------------------------------------------------------------------- -- ");


        } catch (Exception  $e) {

            // throw $e;
            Log::channel($this->clientProvider->name)->info("Exception -- in Pay --Start- ".$this->paymentinfo->id);
            Log::channel($this->clientProvider->name)->info($e->getMessage());
            Log::channel($this->clientProvider->name)->info("Exception --------inPay- End------- ".$this->paymentinfo->id);
            AdminNotify::create([
                'title' => 'لم يستطع الاتصال بالمزود '.$this->clientProvider->name,
                'body' => " يرجى التأكد من المزود نفسه توب اونلاين".$e->getMessage(),
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);
            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ',$response->json('resultDesc'));

            return;
        }



        $result = $response->json(); // it's null

        if ($response->json() == null || $response->status() == 404) {
            AdminNotify::create([
                'title' => 'لم يستطع الاتصال بالمزود '.$this->clientProvider->name,
                'body' => " يرجى التأكد من المزود نفسه توب اونلاين",
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);
            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ',$response->json('resultDesc'));

        } else if ($response->json('resultCode') == "1008") {
            AdminNotify::create([
                'title' => 'لم يستطع الاتصال بالمزود '.$this->clientProvider->name,
                'body' => " يرجى التأكد من صحة معلومات الاتصال (اسم المستخدم,كلمة المرور وبقية التفاصيل)",
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);

            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ',$response->json('resultDesc'));
        } else if ($response->json('resultCode') == "1658" && $response->json('remainAmount') != null) {
            $body = "اجمالي العملية " . $this->paymentinfo->total_price . "\n" . "رصيدك الحالي " . $response->json('remainAmount') . " ريال يمني ";
            AdminNotify::create([
                'title' => 'رصيدك غير لدى '.$this->clientProvider->name.' كافي لتنفيذ عملية ',
                'body' => $body,
                'link' => route('paymentinfo.show', $this->paymentinfo)
            ]);

            $this->updatePay(
                3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ',$body."\n".$response->json('resultDesc'));
            //;
        } else if ($response->json('resultCode') == "1658") {
            AdminNotify::create([
                'title' => '  الفئة غير متوفرة '.$this->clientProvider->name,
                'body' => $response->json('resultDesc'),
                'link' => route('provider_products.edit', $this->paymentinfo->order->product->provider_product()->first()->id)
            ]);

            $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ', $response->json('resultDesc'));
        } else if ($response->json('resultCode') == "1220") {

            Log::channel($this->clientProvider->name)->info('Wrong Id For ------'.$this->paymentinfo->id);
          
            $this->updatePay(3,'Id الحساب غير صحيح يرجى التأكد من صحته ', $response->json('resultDesc'));

        }
        else if ($response->json('resultCode') == "1017"){
            $this->updatePay(3,'عذرا فشل الطلب يرجى اعادة الطلب مرة اخرى ', $response->json('resultDesc'));

        }

        else {





            if ($this->paymentinfo->order->product->provider_product()->first()->direct) {

                sleep(1);



                try {

                    $check = $this->chack_state($transid);

                    //Log::useFiles(storage_path().'/logs/top_online_log.log');

                    Log::channel($this->clientProvider->name)->info('$check---------[First One------'.$this->paymentinfo->id);
                    Log::channel($this->clientProvider->name)->info($check);
                    Log::channel($this->clientProvider->name)->info('$check----------End First-----'.$this->paymentinfo->id);

                    // Log::channel($this->clientProvider->name)->info($check->json());

                    // Log::log(0,'',);
                } catch (Exception $e) {

                    AdminNotify::create([
                        'title' => 'لم يستطع التحقق من حالة العملية بالمزود '.$this->clientProvider->name,
                        'body' => " يرجى التأكد من المزود نفسه توب اونلاين يرجى التأكد يدويا من حالة العملية ".$e->getMessage(),
                        'link' => route('paymentinfo.show', $this->paymentinfo)
                    ]);
                    // $this->updatePay(3,'الخدمة المطلوبة غير متاحة في الوقت الحالي ',$response->json('resultDesc'));
                    Log::channel($this->clientProvider->name)->info("Error Check Status-------  Start in First Check : ".$this->paymentinfo->id);
                    Log::channel($this->clientProvider->name)->info($e->getMessage());
                    // throw $e;
                    return;
                }


                if ($check->json() == null || $check->status() == 404) {
                    AdminNotify::create([
                        'title' => "تم ارسال طلب ولم يستطع التحقق من حالتها",
                        'body' => 'يرجى التواصل مع المزود '.$this->clientProvider->name.' , ومعالجة العملية يدويا ',
                        'link' => route('paymentinfo.show', $this->paymentinfo)

                    ]);
                    Log::channel($this->clientProvider->name)->info("Error Check Status 404 {: ".$this->paymentinfo->id);
                    Log::channel($this->clientProvider->name)->info($check);

                    return;

                } else {

                    $check = $check->json();

                    $i = 0;
                    while ($check['isBan'] == 0 && $check['isDone']==0 && $i<10)  {
                        try {

                            $check = $this->chack_state($transid)->json();
                            Log::channel('check')->info("Check Status : ".$this->paymentinfo->id);
                            Log::channel($this->clientProvider->name)->info("  Check  : ---------{".$i);
                            Log::channel($check);
                            Log::channel($this->clientProvider->name)->info("  Check  : ---------}".$i);

                        } catch (Exception $e) {

                            AdminNotify::create([
                                'title' => "تم ارسال طلب ولم يستطع التحقق من حالتها",
                                'body' => 'يرجى التواصل مع المزود '.$this->clientProvider->name.' , ومعالجة العملية يدويا ',
                                'link' => route('paymentinfo.show', $this->paymentinfo)

                            ]);
                            Log::channel($this->clientProvider->name)->info("Error Check Status : ".$this->paymentinfo->id);
                            Log::channel($this->clientProvider->name)->info($e->getMessage());

                            $product = $this->paymentinfo->order->product;
                            $dispatch_at = $product->provider_product()->first()->dispatch_at;
                    
                    
                            CheckTopOnlineProssce::dispatch($this->paymentinfo, $transid);
                                
                            break;
                            return;
                        }
                        $i++;
                    }




                    if ($check['isBan'] == 0 && $check['isDone']==0) {

                        $product = $this->paymentinfo->order->product;
                        $dispatch_at = $product->provider_product()->first()->dispatch_at;
                
                        CheckTopOnlineProssce::dispatch($this->paymentinfo, $transid);
                        return;
                    }
                    else if ($check['resultCode'] == "0" && $check['isDone'] == 1) {
                        // اذا الرصيد نقص معناته انه نجحت العملية
                        $state = 2;

                        $body = "المنتج :  " . $this->paymentinfo->order->product->name;
                        $body .= "\n";
                        $body .= "السعر : " . $this->paymentinfo->orginal_total;
                        $body .= "\n";
                        $body .= "العميل : " . $this->paymentinfo->user->name;


                        AdminNotify::create([
                            'title' => 'عملية تم تنفيذها بواسطة'.$this->clientProvider->name,
                            'body' => $body,
                            'link' => route('paymentinfo.show', $this->paymentinfo)
                        ]);

                        Log::channel($this->clientProvider->name)->info("  Check  : ");
                        Log::channel($this->clientProvider->name)->info($check);
                        //
                        Log::channel($this->clientProvider->name)->info("  paymentinfo : ");
                        Log::channel($this->clientProvider->name)->info($this->paymentinfo->id);


                        // "Player Name"
                        // $error_note = $check['note'];
                        $error_note = "تم تنفيذ العملية بنجاح"."\n". $check['note'];

                    } else {
                        //مالم معناته فشل الطلب بسبب ان الايدي خطاء
                        $state = 3;



                        $body = "المنتج :  " . $this->paymentinfo->order->product->name;
                        $body .= "\n";
                        $body .= "السعر : " . $this->paymentinfo->orginal_total;
                        $body .= "\n";
                        $body .= "العميل : " . $this->paymentinfo->user->name;

                        AdminNotify::create([
                            'title' => 'عملية تم رفضها بواسطة   '.$this->clientProvider->name,
                            'body' => $body,
                            'link' => route('paymentinfo.show', $this->paymentinfo)
                        ]);
                        if (Str::contains($check['reason'], 'Invalid Player ID'))
                            $error_note = "ID اللاعب غير صحيح يرجى التحقق من صحة الاي دي.";
                        else
                            $error_note = "ID اللاعب غير صحيح يرجى التحقق من صحة الاي دي.";

                            Log::channel($this->clientProvider->name)->info("Check Reson : ".$this->paymentinfo->id);
                            Log::channel($this->clientProvider->name)->info($check);

                    }

                    // $this->paymentinfo->update([
                    //     'state' => $state,
                    //     'note' => $error_note
                    // ]);
                    $this->updatePay($state,$error_note,$check['reason']."\n----------------note-----\n".$check['note']);

                }
            } else {

        $product = $this->paymentinfo->order->product;
        $dispatch_at = $product->provider_product()->first()->dispatch_at;


                CheckTopOnlineProssce::dispatch($this->paymentinfo, $transid)->onQueue($dispatch_at);
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



    function updatePay($state,$error_note,$top_note="") {

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
            'note' => $top_note
        ]);
        $this->paymentinfo->excuted_status()->save($byh);
    }



    public function getParametres()
    {

        $order = $this->paymentinfo->order;
        // return dd($order->reqs);
        $reqs = $this->paymentinfo->order->product->provider_product()->first()->reqs;

        foreach ($order->reqs as $v) {
            $value = trim($v['value']);


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
