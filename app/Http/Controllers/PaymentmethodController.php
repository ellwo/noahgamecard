<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\Processetoken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentmethodController extends Controller
{
    //


    function send($req,$user){
        $url = 'https://fcm.googleapis.com/fcm/send';

        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK',
         'id' => $req->id,
         'status'=>"done");
        $notification = array(
        'title' =>$req['title'],
        'text' => $req['body'],
        'image'=> $req['img'],
        'sound' => 'default',
        'badge' => '1',);
        $arrayToSend = array(
        'to' => $user->f_token->token,
        'notification' => $notification,
        'data' => $dataArr,
        'priority'=>'high');

        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: key=' . config('firebase.server_key'),
            'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        //var_dump($result);
        curl_close ( $ch );
    }

   public  function index(Request $request){




    $user=User::find(auth()->user()->id);

    $req=[];
        $req['title']="hello";
    $req['body']="اول اشعار";
    $req['img']=config('mysetting.logo');



    $this->send($req,$user);

    return $user->acivites_groupByDate();

    if($user!=null){
    return [

        "responInfo"=>[
            "state"=>true,
        "errors"=>null,
        ],
        "orders_gr"=>$user->orders_gr()
    ];


    }
    $user=User::find(auth()->user()->id);

    $role=$user->hasRole('تاجر');

    return [
        'user'=>$user,
        'role'=>$role
    ];

   return $user->orders_gr();

   ;
//    ->groupBy(
//         function($data){
//           return  $data->paymentinfo_one()->id;
//         }
//     );


    //return $user->orders[0]->paymentinfo->first();
    return $user->orders_gr();

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.pubg.com/shards/steam/players/$51422956208');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Accept: application/vnd.api+json';
    $headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJmOGViMzdhMC04ZjkxLTAxM2ItYzcyZi0wOWZlOTFiMjk0MWIiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNjc2NDg4MDczLCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImNoZWNrdXNlcl9ieV9pIn0.7BMOzaCo8NP0iXa8Ob9RpFIeYW3E7mhzXbo098s0n2M';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);


    // $endpoint = 'https://api.pubg.com/shards/steam/players/51422956208';
    // //str_replace('{platform}', $this->config->getPlatform(), self::API_URL . $path);

    // $client = new \GuzzleHttp\Client();

    // $response = $client->request('GET', $endpoint, [
    //     'headers' => [
    //         'Authorization' =>  'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJmOGViMzdhMC04ZjkxLTAxM2ItYzcyZi0wOWZlOTFiMjk0MWIiLCJpc3MiOiJnYW1lbG9ja2VyIiwiaWF0IjoxNjc2NDg4MDczLCJwdWIiOiJibHVlaG9sZSIsInRpdGxlIjoicHViZyIsImFwcCI6ImNoZWNrdXNlcl9ieV9pIn0.7BMOzaCo8NP0iXa8Ob9RpFIeYW3E7mhzXbo098s0n2M',
    //         'Accept' => 'application/vnd.api+json'
    //     ]
    // ]);

    // return json_decode($response->getBody()->getContents(), true);
// Print the data out onto the page.
return  dd($result);


    $helps_steps=[
        "0"=>[
            "title"=>"الخطوة الاولى",
            "photo_pos"=>null,
            "body_text"=>"الذهاب الى اقرب صراف وتحويل المبلغ كاملا بعملة الدولار او مايقابلها بالسعر الحالي.",
            "image"=>null,
            "hasphoto"=>false
        ],
        "1"=>[
            "title"=>"الخطوة الثانية",
            "photo_pos"=>null,
            "hasphoto"=>false,
            "image"=>null,
            "body_text"=>"ايداع المبلغ لمعلومات التواصل التالية\n\tالاسم:نوح زيد\n\tرقم الهاتف:777851533\n\tالعنوان:صنعاء "
        ],
        "2"=>[
            "title"=>"الخطوة الثالثة",
            "photo_pos"=>null,
            "hasphoto"=>false,
            "image"=>null,
            "body_text"=>"يجب ان تتاكد من صحة المعلومات قبل التحويل "
        ],
        "3"=>[
            "title"=>"الخطوة الاخيرة",
            "photo_pos"=>null,
            "hasphoto"=>false,
            "image"=>null,
            "body_text"=>"ادخال رقم الحوالة في هذا المربع بعناية والانتباه لاية اخطاء"
        ],
    ];

   $paymentinfo= Paymentmethod::find(1);
$paymentinfo->help_steps=$helps_steps;
$paymentinfo->save();


return dd($paymentinfo);




















    $user=User::find(auth()->user());

    $orders=$user->orders;
    return $data=[
//'user'=>$user
        'data'=>$orders
    ];
    return $this->create_order($request);
    return ['state'=>$this->check_order($request["token"],$request["order_id"])];
   }







   public function create(){


    $user=User::find(auth()->user()->id);

   // $orders=$user->orders->first();
    return $data=[
//'user'=>$user
        'data'=>$user->orders_gr()
    ];
    return $this->pay_order(request());
   }



   public function pay_order($request){

    if($this->check_order($request["token"],$request["order_id"])){

        $vildat = Validator::make(
            $request->all(),
         ['code' => ['required', 'string','max:255', 'unique:paymentinfos,code']
           ,'paymentmethod_id'=>['required','exists:paymentmethods,id'],
           'order_id'=>['required','unique:order_paymentinfo,order_id']
        ]);


        if ($vildat->fails()) {
        return $date=[
            'errors'=>$vildat->errors(),
        ];
        }
        else{



            if($this->check_code($request["code"]))
            {
            $paymentinfo=Paymentinfo::create([
                'code'=>$request["code"],
                'paymentmethod_id'=>$request["paymentmethod_id"],
                'img'=>$request['img']??""
            ]);
            $order=Order::find($request["order_id"]);
            $paymentinfo->orders()->attach($order);
            $order->state=1;
            $order->processe_token()->delete();
            $order->save();

            return $data=[
                'paymentinfo'=>$paymentinfo,
                'paymentinfo->Orders'=>$paymentinfo->orders,
                'order->paymentinfo'=>$order->paymentinfo
            ];

        }

        else{
            return $data=[
                'code'=>'ليس صحيح'
            ];
        }

        }
    }

    else{
        return $data=[
            'checkOrder'=>false
        ];
    }


   }



   public function check_code($code){
    if($code=="888")
    return true;
    else
    return false;
   }



   public function cancel_order($request){

    $order=Order::find($request["order_id"]);

   }




   public function check_order($token,$order_id){
    $token=$token;
    $order=Order::find($order_id);
    if($order==null)
    return false;

    else{
    $oldtoken=$order->processe_token->first();
    $expired_at=date_create($oldtoken->expired_at);
    $dif=now()->isAfter($expired_at);
    $comper=Hash::check( $oldtoken->token,$token);
    if(!$dif &&$comper && $order->user->id ==auth()->user()->id){
    return true;
    }
    else
    return false;

    }
}


  public function create_order($request){

    $order=Order::create([
        'product_id'=>$request['product_id'],
        'qun'=>$request['qun'],
        'user_id'=>auth()->user()->id,
        'g_id'=>$request['g_id'],
        'email'=>$request['g_email'],
        'password'=>$request['g_password'],
        'state'=>0,
    ]);
      $token=  Str::random(8);
      $token.=time();
      $date=new DateTime('now');
      $date->modify('+20 minutes');


      $processe_token=Processetoken::create([
        'processe_id'=>$order->id,
        'processe_type'=>get_class($order),
        'token'=>$token,
        'expired_at'=>$date,
        'user_id'=>auth()->user()->id
    ]);


    return [
        'order'=>$order,
        'token'=>Hash::make($token),
        'date'=>$date,
        'processe_token'=>$processe_token

    ];
    //$processe_token->processe()->


  }





}
