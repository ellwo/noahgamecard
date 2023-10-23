<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientProvider;
use App\Models\Paymentinfo;
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


    function genurateToken()
     {

        $username="777777777";
        $password="Asd777777777";
        $id="17577";
        $transid=rand(1,4522220);
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

        $username="777777777";
        $password="Asd777777777";
        $id=17577;
        $mobile="777777777";
        $transid=rand(1,4766522);
        $hashPassword=md5($password);
        $token=md5($hashPassword.$transid.$username.$mobile);
        $pay=Paymentinfo::find(121);
        $url="https://toponline.yemoney.net/api/yr/gameswcards";
        //?userid=".$id."&"."moblie=778514141&tansid=".$transid."&token=$token&".$this->getParametres($pay)."uniqcode=63"

       // $response= Http::get($url);

      // return dd($token);
       $queryParams=$this->getParametres($pay);
       $queryParams['token']=$token;
       $queryParams['userid']=$id;
       $queryParams['transid']=$transid;
       $queryParams['mobile']=$mobile;
        $queryParams['uniqcode']="325";
        $queryParams['playerid']="005555";
        $queryParams['type']="pubg";

    //    return dd($queryParams);


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
