<?php

namespace App\Jobs;

use App\Models\AdminNotify;
use App\Models\ClientProvider;
use App\Models\Paymentinfo;
use App\Models\PaymentinfoExecuteBy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TopOnlinePayByAPIJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public Paymentinfo $paymentinfo;
    public $userid = 17577;
    public $mobile = "777777777";
    public $username = "777777777";
    public $password = "Asd777777777";
    public $pay_url='https://toponline.yemoney.net/api/yr/gameswcards';
    public $chack_url='https://toponline.yemoney.net/api/yr/info';
    
    public function __construct(Paymentinfo $paymentinfo)
    {
        $this->paymentinfo = $paymentinfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


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

            $this->paymentinfo->update([
                'state' => 3,
                'note' => "ID اللاعب غير صحيح "
            ]);
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

            $this->paymentinfo->update([
                'state' => $state,
                'note' => $error_note
            ]);

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


    // function check_rassed()
    // {
    //     # code...
    //     $this->username="777777777";
    //     $this->password="Asd777777777";
    //     $id=17577;
    //     $this->mobile="777777777";
    //     $transid=rand(1,452);
    //     $hashPassword=md5($this->password);
    //     $token=md5($hashPassword.$transid.$this->username.$this->mobile);
    //     $pay=Paymentinfo::find($this->paymentinfo->id);
    //    $queryParams=$this->getParametres($pay);
    //    $queryParams['token']=$token;
    //    $queryParams['userid']=$id;
    //    $queryParams['transid']=$transid;
    //    $queryParams['mobile']=$this->mobile;
    //     $queryParams['uniqcode']="325";
    //     $queryParams['playerid']="0000";
    //     $queryParams['type']="pubg";
    //     $response = Http::get('https://toponline.yemoney.net/api/yr/gameswcards', $queryParams);

    //     $amount=$response->json();
    //     return $amount;
    // }

    function chack_state($transid)
    {
        $url = $this->pay_url;
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
}
