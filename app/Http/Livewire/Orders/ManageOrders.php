<?php

namespace App\Http\Livewire\Orders;

use App\Models\Paymentinfo;
use Livewire\Component;
use Livewire\WithPagination;

class ManageOrders extends Component
{
    use WithPagination;
    public $type="";
    public $username=-1;
    public $search="";
    public $delete_orderid="no";
    public $status=4;
    public $paginate_num=20;
    protected  $listeners= ['updatedUser'=>'changeUser'];



    public function render()
    {


         $paymentinfos=[];

         if($this->status==4)
       { $paymentinfos=Paymentinfo::has('orders')->withCount('orders')
        ->with('paymentmethod')
        ->where(function($q){
            if($this->username==-1)
            $q->where('code','LIKE','%'.$this->search.'%')->orWhereHas('orders',function($order){
                $order->where('reqs','LIKE','%'.$this->search."%");
            });
            else{
                $q->
                where('user_id','=',$this->username)->
               where(function($q2){
                $q2->where('code','LIKE','%'.$this->search.'%')->orWhereHas('orders',function($order){
                    $order->where('reqs','LIKE','%'.$this->search."%");
                });
               });

            }


        })
        ->orderBy('id','desc')->paginate($this->paginate_num);
       }
        else
       {

        $paymentinfos=Paymentinfo::has('orders')
        ->where(function($q){

            if($this->username==-1)
            $q->where('code','LIKE','%'.$this->search.'%')->orWhereHas('orders',function($order){
                $order->where('reqs','LIKE','%'.$this->search."%");
            });
            else{
                $q->
                where('user_id','=',$this->username)->
                where('code','LIKE','%'.$this->search.'%')->orWhereHas('orders',function($order){
                    $order->where('reqs','LIKE','%'.$this->search."%");
                });

            }

            })
        ->withCount('orders')
        ->with('paymentmethod')
        ->where('state','=',$this->status)->orderBy('id','desc')->paginate($this->paginate_num);
}
        return view('admin.orders.table',['paymentinfos'=>$paymentinfos])->layout('components.dashborade.index');
    }


    function refresh_page(){
        $this->resetPage();
        $this->page=1;
        $this->status=4;
        $this->search="";
        $this->username=-1;
    }


    public function updatedSearch(){
        $this->resetPage();
    }

    function changeUser($id)  {
        $this->username=$id;
    }




}
