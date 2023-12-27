<?php

namespace App\Http\Livewire;

use App\Jobs\SendNotifiyToUsers;
use App\Models\UserNotification;
use Livewire\Component;
use Livewire\WithPagination;

class UserNotifiyTable extends Component
{
    use WithPagination;
    public $type="";
    public $username=-1;
    public $search="";
    public $delete_orderid="no";
    public $status=-1;
    public $paginate_num=20;
    public $body="";

    protected  $listeners= ['updatedUser'=>'changeUser'];


    function changeUser($id)  {
        $this->username=$id;
    }

    public function render()
    {

        $notfis=UserNotification::where(function($q){

            if($this->status!=-1)
            $q->where('sented','=',$this->status);
        })->where(function($q){
            if($this->username!=-1)
            $q->where('user_id','=',$this->username);
        })->orderBy('created_at','desc')->paginate($this->paginate_num);

        return view('admin.user_notifiy.table',['notifiys'=>$notfis]);
    }
    function refresh_page(){
        $this->resetPage();
        $this->page=1;
        $this->status=-1;
        $this->username=-1;
    }


    function reSandall() {

        $notfis=UserNotification::where('sented','=',0)->get();

        foreach ($notfis as $n) {

            SendNotifiyToUsers::dispatch($n);
            # code...
        }

    }
    function resend($id)  {
       $n= UserNotification::find($id);
       if($n!=null)
        SendNotifiyToUsers::dispatch($n);
    }
    function setBody($body){
        $n= UserNotification::find($body);
        $this->body=$n->body;
    }
}
