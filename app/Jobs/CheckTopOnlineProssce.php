<?php

namespace App\Jobs;

use App\Models\AdminNotify;
use App\Models\Paymentinfo;
use App\Models\PaymentinfoExecuteBy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ClientProvider;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckTopOnlineProssce implements ShouldQueue
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
    // public $pay_url='https://toponline.yemoney.net/api/yr/gameswcards';
    public $chack_url='https://toponline.yemoney.net/api/yr/info';
    public $transid;
    public function __construct($paymentinfo,$transid)
    {
        $this->paymentinfo=$paymentinfo;
        //
        $this->transid=$transid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $check = $this->chack_state($this->transid);



        if($check->json()==null || $check->status()==404){
            AdminNotify::create([
                'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                'body'=>'يرجى التواصل مع المزود توب اونلاين , ومعالجة العملية يدويا '
               ]);

        }
        else{

            $check=$check->json();

            $i=0;
            while($check['isBan']==0){
                $check=$this->chack_state($this->transid);
           $i++;
            }
    
    
         
    
    
            if ($check['resultCode']=="0" && $check['isDone']==1) {
                // اذا الرصيد نقص معناته انه نجحت العملية
                $state = 2;
    
                $body="المنتج :  ".$this->paymentinfo->order->product->name;
                $body.="\n";
                $body.="السعر : ".$this->paymentinfo->orginal_total;
                $body.="\n";
                $body.="العميل : ".$this->paymentinfo->user->name;
                
                
                AdminNotify::create([
                    'title'=>'عملية تم تنفيذها بواسطة TopOnline  ',
                    'body'=>$body,
                    'link'=>route('paymentinfo.show',$this->paymentinfo)
                ]);
                $error_note = "تم تنفيذ العملية بنجاح";
            } else {
                //مالم معناته فشل الطلب بسبب ان الايدي خطاء
                $state = 3;
    

                $body="المنتج :  ".$this->paymentinfo->order->product->name;
                $body.="\n";
                $body.="السعر : ".$this->paymentinfo->orginal_total;
                $body.="\n";
                $body.="العميل : ".$this->paymentinfo->user->name;
                
                
                AdminNotify::create([
                    'title'=>'عملية تم رفضها بواسطة TopOnline  ',
                    'body'=>$body,
                    'link'=>route('paymentinfo.show',$this->paymentinfo)
                ]);
                if(Str::contains($check['reason'],'Invalid Player ID'))
                $error_note = "ID اللاعب غير صحيح يرجى التحقق من صحة الاي دي.";
            }
    
            // $this->paymentinfo->update([
            //     'state' => $state,
            //     'note' => $error_note
            // ]);
    
            $pay=Paymentinfo::find($this->paymentinfo->id);
            $pay->state=$state;
            $pay->note=$error_note;
    
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
            $pay->save();

        }


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

        return $response;
    }
    function genurateToken($transid)
    {
        $hashPassword = md5($this->password);
        $token = md5($hashPassword . $transid . $this->username . $this->mobile);
        return $token;
    }

}
