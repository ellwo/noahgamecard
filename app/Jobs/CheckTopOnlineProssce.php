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
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

        if($this->paymentinfo->state!=3 || $this->paymentinfo->state!=2){

            try{

                $check = $this->chack_state($this->transid);
                Log::channel('top_online')->info("-----------------  Check  ");
                Log::channel('top_online')->info($check);
                Log::channel('top_online')->info($this->paymentinfo);


            }
            catch(Exception $e){
              //  throw $e;
                AdminNotify::create([
                    'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                    'body'=>'يرجى التواصل مع المزود توب اونلاين , ومعالجة العملية يدويا '.$e->getMessage()
                   ]);

                   Log::channel('top_online')->info("Error Check Status : ".$this->paymentinfo->id);
                   Log::channel('top_online')->info($e->getMessage());
                   Log::channel('top_online')->info($check);



            }


            if($check->json()==null || $check->status()==404){
                AdminNotify::create([
                    'title'=>"تم ارسال طلب ولم يستطع التحقق من حالتها",
                    'body'=>'يرجى التواصل مع المزود توب اونلاين , ومعالجة العملية يدويا '
                   ]);

                   Log::channel('top_online')->info('Error Check Status  $check->json()==null || $check->status()==404 : '.$this->paymentinfo->id);
                   Log::channel('top_online')->info($e->getMessage());
                   Log::channel('top_online')->info($check);

            }
            else{

                $check=$check->json();
                Log::channel('top_online')->info("Check Of json-------------");
                Log::channel('top_online')->info($check);

                Log::channel('top_online')->info("Check Of json-------------");


                $i=0;
                // while ($check['isBan'] == 0 && $check['isDone']==0)  {
                //     try {

                //         $check = $this->chack_state($this->transid)->json();
                //         Log::channel('top_online')->info("Check Status : ".$this->paymentinfo->id);
                //         Log::channel('"  Check  : ".');
                //         Log::channel('top_online')->info($check);

                //     } catch (Exception $e) {

                //         AdminNotify::create([
                //             'title' => "تم ارسال طلب ولم يستطع التحقق من حالتها",
                //             'body' => 'يرجى التواصل مع المزود توب اونلاين , ومعالجة العملية يدويا ',
                //             'link' => route('paymentinfo.show', $this->paymentinfo)

                //         ]);
                //         Log::channel('top_online')->info("Error Check Status : ".$this->paymentinfo->id);
                //         Log::channel('top_online')->info($e->getMessage());

                //         break;
                //         return;
                //     }
                //     $i++;
                // }




                if ($check['resultCode']=="0" && $check['isDone']==0 && $check['isDone']==0) {
                    $product = $this->paymentinfo->order->product;
                    $dispatch_at = $product->provider_product()->first()->dispatch_at;


                            CheckTopOnlineProssce::dispatch($this->paymentinfo, $this->transid)->onQueue($dispatch_at);
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
                        'title'=>'عملية تم تنفيذها بواسطة TopOnline  ',
                        'body'=>$body,
                        'link'=>route('paymentinfo.show',$this->paymentinfo)
                    ]);

                    Log::channel('top_online')->info("Pa Sa Status : ".$this->paymentinfo->id);
                   Log::channel('top_online')->info("-----------------  Check  ");
                    Log::channel('top_online')->info($check);
                    Log::channel('top_online')->info($this->paymentinfo);


                    $error_note = "تم تنفيذ العملية بنجاح"."\n". $check['note'];
                } else {
                    //مالم معناته فشل الطلب بسبب ان الايدي خطاء
                    $state = 3;



                    $body="المنتج :  ".$this->paymentinfo->order->product->name;
                    $body.="\n";
                    $body.="السعر : ".$this->paymentinfo->orginal_total;
                    $body.="\n";
                    $body.="العميل : ".$this->paymentinfo->user->name;
                    $body.="\n";
                    $body.="عدد المحاولات  : ".$i;
                    AdminNotify::create([
                        'title'=>'عملية تم رفضها بواسطة TopOnline  ',
                        'body'=>$body,
                        'link'=>route('paymentinfo.show',$this->paymentinfo)
                    ]);
                    if(Str::contains($check['reason'],'Invalid Player ID'))
                    $error_note = "ID الحساب غير صحيح يرجى التحقق من صحة الاي دي.";
                else
                $error_note = "ID الحساب غير صحيح يرجى التحقق من صحة الاي دي.";


                // Log::channel('top_online')->info('Error Check Status  $check->json()==null || $check->status()==404 : '.$this->paymentinfo->id);
                Log::channel('top_online')->info("Check whne Player Id ");
                Log::channel('top_online')->info($check);

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

            }
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
