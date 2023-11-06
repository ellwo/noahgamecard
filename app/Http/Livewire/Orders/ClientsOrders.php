<?php

namespace App\Http\Livewire\Orders;

use App\Models\ClientProvider;
use App\Models\Paymentinfo;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsOrders extends Component
{
    use WithPagination;
    public $type="";
    public $username;
    public $search="";
    public $delete_orderid="no";
    public $status=4;
    public $paginate_num=20;
    public $deptid;
    public $client;
    protected  $listeners= ['updatedUser'=>'changeUser'];


    protected $queryString=['search','page','deptid','username','client'];



    // public function getQueryString()
    // {
    //     return ['deptid'=>$this->deptid];
    // }

    public function mount($deptid="all",$username=-1,$client)
    {
        $this->deptid=$deptid;
        $this->username=$username;
        

        $this->client=$client;
    }

    public function render()
    {


         $paymentinfos=[];

         $client=ClientProvider::find($this->client);
        //  $client->paymentinfos
         if($this->status==4)
       { $paymentinfos=$client->paymentinfos()->has('orders')->withCount('orders')
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
        ->whereHas('order',function($o){
            if($this->deptid!="all"){

            $o->whereHas('product',function($proq){
                $proq->where('department_id','=',$this->deptid);
            });
            }
        })->orderBy('id','desc')->paginate($this->paginate_num);
       }
        else
       {

        $paymentinfos=$client->paymentinfos()->has('orders')
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
        ->where('state','=',$this->status)->whereHas('order',function($o){
            if($this->deptid!="all"){

            $o->whereHas('product',function($proq){
                $proq->where('department_id','=',$this->deptid);
            });
            }
        })->orderBy('id','desc')->paginate($this->paginate_num);
}
        return view('admin.client-providers.table-detail',['paymentinfos'=>$paymentinfos])->layout('components.dashborade.index');
    }


    function refresh_page(){
        $this->resetPage();
        $this->page=1;
        $this->status=4;
        $this->search="";
        $this->username=-1;
        $this->deptid="all";
        $this->emit('reset');
    }


    public function updatedSearch(){
        $this->resetPage();
    }

    function changeUser($id)  {
        $this->username=$id;
    }




}
