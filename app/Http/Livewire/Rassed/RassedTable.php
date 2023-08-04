<?php

namespace App\Http\Livewire\Rassed;

use App\Models\Coin;
use App\Models\Paymentinfo;
use App\Models\RassedActevity;
use App\Models\User;
use App\Models\UserNotification;
use Livewire\Component;
use Livewire\WithPagination;

class RassedTable extends Component
{
    use WithPagination;
    public $type="";
    public $username=-1;
    public $search="";
    public $delete_orderid="no";
    public $paymentInfo=-1;
    public $amount=0;
    public $note="";
    public $status=4;
    public $coin_id=1;

    public function render()
    {


if($this->status!=4)
{
$paymentinfos =Paymentinfo::whereHas('rassed_actevity',function($q){


    if($this->username==-1)
    $q->where('amount','>=',0);
    else {
    $q->where('amount','>=',0)->whereHas('rassed',function($quer){
        $quer->where('user_id','=',$this->username);
    });
    }
})->where('state','=',$this->status)->where('code','LIKE','%'.$this->search.'%')->orderBy('updated_at','desc')->paginate(15);
}
else{

    $paymentinfos =Paymentinfo::whereHas('rassed_actevity',function($q){

        if($this->username==-1)
        $q->where('amount','>=',0);
        else {
        $q->where('amount','>=',0)->whereHas('rassed',function($quer){
            $quer->where('user_id','=',$this->username);
        });
        }

    })->where('code','LIKE','%'.$this->search.'%')->orderBy('updated_at','desc')->paginate(15);

}

$coustmers=User::whereHas('rassed_acetvities',function($q){
       $q->where('amount','>=',0);
})->get();
         $coins=Coin::all();
        return view('admin.rassed.table',['paymentinfos'=>$paymentinfos,'coustmers'=>$coustmers,'coins'=>$coins])->layout('components.dashborade.index');

    }



    function refresh_page(){




        $userNotification=UserNotification::orderBy('id','desc')->first();











       //
        $url ="https://fcm.googleapis.com/v1/projects/noohcardgame/messages:send";
        // 'https://fcm.googleapis.com/fcm/send';

        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK',
         'id' => $userNotification->id,
         "data"=>$userNotification->data,
         'status'=>"done",);
        $notification = array(
        'title' =>$userNotification->title,
        'body' => $userNotification->body,
        'image'=> $userNotification->img??'',
        'sound' => 'default',
        'badge' => '1',);
        $arrayToSend = array(
        'registration_ids' => $userNotification->user->f_token->pluck('token')->toArray(),
        'notification' => $notification,
        'data' => $dataArr,
        'priority'=>'high');

        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: Bearer ' . config('firebase.server_key'),
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

       $result =
        curl_exec ( $ch );

        var_dump($result);
        curl_close ( $ch );



        $this->resetPage();
        $this->page=1;
        $this->status=4;

    }

 function UsernameUpdated() {

    return dd($this->username);
 }

 function accepte($id)  {
    $pa=RassedActevity::find($id);
    $this->amount=$pa->camount;
    $this->paymentInfo=$pa->paymentinfo_id;
 }

 function v_accepte()  {
    $payment_info=Paymentinfo::find($this->paymentInfo);
    $payment_info->state=1;
   $rassed= $payment_info->rassed_actevity->id;
   $payment_info->total_price=$this->amount;
   $payment_info->orginal_total=$this->amount;

   $rassed_a=RassedActevity::find($rassed);
   $rassed_a->amount=$this->amount;
   $rassed_a->save();
   $payment_info->save();

   $this->amount=0;
    $this->paymentInfo=-1;
 }








 function d_accepte()  {
    $payment_info=Paymentinfo::find($this->paymentInfo);
    $payment_info->state=3;
    $payment_info->note=$this->note;
    $ras=$payment_info->rassed_actevity;
    $ras->amount=0.0;
    $ras->updated_at=now();
    $ras->save();
    $payment_info->save();
   $this->amount=0;
    $this->paymentInfo=-1;
 }

 function cancel() {
    $this->amount=0;
    $this->paymentInfo=-1;

 }

}
