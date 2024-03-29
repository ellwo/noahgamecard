<?php

namespace App\Jobs;

use App\Models\AdminNotify;
use App\Models\Paymentinfo;
use App\Models\PaymentinfoExecuteBy;
use App\Models\CallApiCount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ClientProvider;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
    public $mobile = "778928008";
    public $username = "778928008";
    public $password = "Asd777777777";
    // public $pay_url='https://toponline.yemoney.net/api/yr/gameswcards';
    public $chack_url='https://toponline.yemoney.net/api/yr/info';
    public $transid;
    public $clientProvider=null;
    public function __construct($paymentinfo,$transid)
    {

        $this->paymentinfo=$paymentinfo;
       
        $this->transid=$transid;

        if ($this->paymentinfo->orders->count() > 0) {
            $product = $this->paymentinfo->order->product;

            if ($product->provider_product->count() > 0) {

                $clientProvider = $product->provider_product()->first()->client_provider;

                if ($clientProvider!=null) {
                    $this->userid=$clientProvider->api_userid;
                    $this->mobile=$clientProvider->api_phone;
                    $this->password=$clientProvider->api_password;
                    $this->chack_url=$clientProvider->api_checkurl;
                    $this->username=$clientProvider->api_username;
                    $this->clientProvider = $clientProvider;
                    
                    # code...
                }

            }
        
        }


        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        //


        $call_api_counts=$this->paymentinfo->call_api_counts()->where('client_provider_id','=',$this->clientProvider->id)->get();

        $call_api=null;
        if(count($call_api_counts)>0){
            
            $call_api=$call_api_counts[0];


            $call_api->update([
                'count'=>$call_api->count+1
            ]);
            $call_api->save();

        }
        else{
            $call_api=CallApiCount::create([
                'paymentinfo_id'=>$this->paymentinfo->id,
                "info"=>$this->clientProvider->name." رقم العملية [".$this->transid."]",
                "client_provider_id"=>$this->clientProvider->id
            ]);

        }




        if($call_api->count>11){

            $body="تم ارسال اكثر من 10 استعلامات عن حالة الطلب ولم يتستطع ايجاد الرد الرجاء التواصل مع المزود ";
            AdminNotify::create([
                'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                'body'=>'يرجى التواصل مع المزود '.$this->clientProvider->name.' , ومعالجة العملية يدويا \n'.$body,
                'link'=>route('paymentinfo.show',$this->paymentinfo)
            ]);

            return;
        }

        else if($this->paymentinfo->state!=3 || $this->paymentinfo->state!=2 ){

            try{

                $check = $this->chack_state($this->transid);
                Log::channel($this->clientProvider->name)->info("-----------------  Check  ");
                Log::channel($this->clientProvider->name)->info($check);

            }
            catch(Exception $e){
              //  throw $e;
                AdminNotify::create([
                    'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                    'body'=>'يرجى التواصل مع المزود '.$this->clientProvider->name.' , ومعالجة العملية يدويا '.$e->getMessage(),
                    'link'=>route('paymentinfo.show',$this->paymentinfo)
                ]);

                   Log::channel($this->clientProvider->name)->info("Error Check Status : ".$this->paymentinfo->id);
                   Log::channel($this->clientProvider->name)->info($e->getMessage());

                   return;
            }


            if($check->json()==null || $check->status()==404){
                AdminNotify::create([
                    'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                    'body'=>'يرجى التواصل مع المزود '.$this->clientProvider->name.' , ومعالجة العملية يدويا '
                    ,'link'=>route('paymentinfo.show',$this->paymentinfo)
                ]);

                 
                  return;

            }
            else{

                $check=$check->json();

                $i=0;

                if ($check['resultCode']=="0" && $check['isDone']==0 && $check['isBan']==0) {
                    $product = $this->paymentinfo->order->product;
                    $dispatch_at = $product->provider_product()->first()->dispatch_at;



                            CheckTopOnlineProssce::dispatch($this->paymentinfo, $this->transid)->onQueue($dispatch_at)->delay(Carbon::now()->addMinutes(2));
                            return;
                }

               else if ($check['resultCode']=="0" && $check['isDone']==1) {
                    // اذا الرصيد نقص معناته انه نجحت العملية
                    $state = 2;

                    $body="المنتج :  ".$this->paymentinfo->order->product->name;
                    $body.="\n";
                    $body.="السعر : ".$this->paymentinfo->orginal_total;
                    $body.="\n";
                    $body.="العميل : ".$this->paymentinfo->user->name;

                    $body.="\n";
                    $body.="عدد المحاولات  : ".$i;


                    AdminNotify::create([
                        'title'=>'عملية تم تنفيذها بواسطة'.$this->clientProvider->name,
                        'body'=>$body,
                        'link'=>route('paymentinfo.show',$this->paymentinfo)
                    ]);

                    Log::channel($this->clientProvider->name)->info("DONE : ".$this->paymentinfo->id);
                  


                    $error_note = "تم تنفيذ العملية بنجاح"."\n". $check['note'];
                } 
                
                else if ($check['resultCode'] == "1028"){
                    AdminNotify::create([
                        'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                        'body'=>'يرجى التواصل مع المزود '.$this->clientProvider->name.' , ومعالجة العملية يدويا ',
                        'link'=>route('paymentinfo.show',$this->paymentinfo)
                       ]);
    
                
                }
                
                else {
                    //مالم معناته فشل الطلب بسبب ان الايدي خطاء
                    $state = 3;



                    $body="المنتج :  ".$this->paymentinfo->order->product->name;
                    $body.="\n";
                    $body.="السعر : ".$this->paymentinfo->orginal_total;
                    $body.="\n";
                    $body.="العميل : ".$this->paymentinfo->user->name;
                    $body.="\n";
                    $body.="عدد المحاولات  : ".$i;
                   
                    if(Str::contains($check['reason'],'Invalid Player ID'))
                    $error_note = "ID الحساب غير صحيح يرجى التحقق من صحة الاي دي.";
                else
                $error_note = "ID الحساب غير صحيح يرجى التحقق من صحة الاي دي.";


                // Log::channel($this->clientProvider->name)->info('Error Check Status  $check->json()==null || $check->status()==404 : '.$this->paymentinfo->id);
                Log::channel($this->clientProvider->name)->info("Check whne Player Id  WRON=======================".$this->paymentinfo->id);
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
                AdminNotify::create([
                    'title'=>'عملية تم رفضها بواسطة '.$this->clientProvider->name,
                    'body'=>$body,
                    'link'=>route('paymentinfo.show',$this->paymentinfo)
                ]);

            }
        }
        else{
            return;
       
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
        try{

            $response = Http::get($url, $paras);

        }catch(Exception $e){
            throw $e;
        }

        return $response;
    }
    function genurateToken($transid)
    {
        $hashPassword = md5($this->password);
        $token = md5($hashPassword . $transid . $this->username . $this->mobile);
        return $token;
    }

}
