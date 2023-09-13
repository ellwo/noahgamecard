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
    public $paginate_num=20;



    protected  $listeners= ['updatedUser'=>'changeUser'];


    function changeUser($id)  {
        $this->username=$id;
    }
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
})->where('state','=',$this->status)->where('code','LIKE','%'.$this->search.'%')->orderBy('updated_at','desc')->paginate($this->paginate_num);
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

    })->where('code','LIKE','%'.$this->search.'%')->orderBy('updated_at','desc')->paginate($this->paginate_num);

}

$coustmers=User::whereHas('rassed_acetvities',function($q){
       $q->where('amount','>=',0);
})->get();
         $coins=Coin::all();
        return view('admin.rassed.table',['paymentinfos'=>$paymentinfos,'coustmers'=>$coustmers,'coins'=>$coins])->layout('components.dashborade.index');

    }



    function refresh_page(){
        $this->resetPage();
        $this->page=1;
        $this->status=4;
    }


    public function updatedSearch(){
        $this->resetPage();
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
    $rassed= $payment_info->rassed_actevity->id;
    $rassed_a=RassedActevity::find($rassed);
    $rassed_a->amount=$this->amount;
    $rassed_a->save();


    $payment_info->total_price=$this->amount;
    $payment_info->orginal_total=$this->amount;
    $payment_info->state=2;
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
