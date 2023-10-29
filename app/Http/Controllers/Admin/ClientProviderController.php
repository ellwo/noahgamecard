<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\TopOnlinePayByAPIJob;
use App\Models\AdminNotify;
use App\Models\ClientProvider;
use App\Models\Paymentinfo;
use App\Models\PaymentinfoExecuteBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ClientProviderController extends Controller
{

    public function getParametres($paymentinfo)
    {

       $order=$paymentinfo->order;
       // return dd($order->reqs);
       $reqs=$paymentinfo->order->product->provider_product()->first()->reqs;

       foreach($order->reqs as $v){

           $lable=$v['lable'];
           $value=$v['value'];


       $i=0;

           foreach($reqs as $r){
               if($r['lable']==$v['lable']){
                   $reqs[$i]['val']=$value;
               }
               $i++;
           }

       }





       $query="";
       $qq=[];
       foreach($reqs as $r){
        $qq[$r['name']]=$r['val'];
       $query.=$r['name']."=".$r['val']."&";
       }


       return $qq;
       # code...
    }


    function genurateToken($transid)
     {

        $username="777777777";
        $password="Asd777777777";
        $id="17577";
        // $transid=rand(1,4522220);
        $hashPassword=md5($password);
        $token=md5($hashPassword.$transid.$username.$username);

        return $token;

        # code...

     }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $p=Paymentinfo::find(109);

        $p->state=2;


        $body="المنتج :  ".$p->order->product->name;
        $body.="\n";
        $body.="السعر : ".$p->orginal_total;
        $body.="\n";
        $body.="العميل : ".$p->user->name;


        AdminNotify::create([
            'title'=>'عملية تم تنفيذها بواسطة TopOnline  ',
            'body'=>$body,
            'link'=>route('paymentinfo.show',$p)
        ]);

        $p->save();
 $product = $p->order->product;
            $clientProvider = $product->provider_product()->first()->client_provider;

            $byh = PaymentinfoExecuteBy::create([
                'paymentinfo_id' => $p->id,
                'state' => 2,
                'execute_type' => ClientProvider::class,
                'execute_id' => $clientProvider->id,
                'note' => "تم التنفيذ بنجاح"
            ]);
            $p->excuted_status()->save($byh);




    //     $username="777777777";
    //     $password="Asd777777777";
        $id=17577;
        $mobile="777777777";
    //     $transid=rand(1,4766522);
    //     $hashPassword=md5($password);
    //     $token=md5($hashPassword.$transid.$username.$mobile);
    //     $pay=Paymentinfo::find(121);
         $url="https://toponline.yemoney.net/api/yr/gameswcards";
    //     //?userid=".$id."&"."moblie=778514141&tansid=".$transid."&token=$token&".$this->getParametres($pay)."uniqcode=63"


    // //   // return dd($token);
    // $pay=Paymentinfo::first();
    // // TopOnlinePayByAPIJob::dispatchAfterResponse($pay->rassed_actevity);
    // $transid=rand(1,4569);
    // $queryParams=$this->getParametres($pay);
    // //    $queryParams['token']=$token;
    //    $queryParams['userid']=$id;
    //     $queryParams['transid']=$transid;
    //     $queryParams['token']=$this->genurateToken($transid);

    // $queryParams['mobile']=$mobile;
    // //     $queryParams['playerid']="005555";
    //     $queryParams['type']="pubg";

    //    return dd($queryParams);

    // $response= Http::get($url,$queryParams);


    // $url = 'https://toponline.yemoney.net/api/yr/info';
    // // $transid="2303";
    // $paras = [
    //     'transid' => $transid,
    //     'token' => $this->genurateToken($transid),
    //     'userid' => $id,
    //     'mobile' => $mobile,
    //     'action' => 'status'
    // ];
    // $res = Http::get($url, $paras);

    // $res = [];


    // return dd($response->json(),$res);
        // $queryParams = [
        //     'userid' => '17577',
        //     //'mobile' => "778514141",
        //     'transid' => $transid,
        //     'token' => $token,
        //     'playerid' => 5445780000,
        //     'type' => 'pubg',
        //     'uniqcode' => 63,
        // ];

       // $response = Http::get('https://toponline.yemoney.net/api/yr/gameswcards', $queryParams);
//       return dd($response);
     //  dd($response->json(),$queryParams); // it's null
    //   dd($response->collect()); // it's null
  //     dd($response->object()); // it's null

   //    return dd($res);
        // $ch = curl_init ();
        // curl_setopt ( $ch, CURLOPT_URL, $url );
        // $result =
        //  curl_exec ( $ch );
        // curl_close ( $ch );

        // return dd($result);


        //
        return view('admin.client-providers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientProvider  $clientProvider
     * @return \Illuminate\Http\Response
     */
    public function show(ClientProvider $clientProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientProvider  $clientProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientProvider $clientProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientProvider  $clientProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientProvider $clientProvider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientProvider  $clientProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientProvider $clientProvider)
    {
        //
    }
}
