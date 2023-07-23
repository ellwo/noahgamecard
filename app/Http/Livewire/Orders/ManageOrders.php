<?php

namespace App\Http\Livewire\Orders;

use App\Models\Paymentinfo;
use Livewire\Component;
use Livewire\WithPagination;

class ManageOrders extends Component
{
    use WithPagination;
    public $type="";
    public $username="";
    public $search="";
    public $delete_orderid="no";
    public $status=4;

    public function render()
    {


         $paymentinfos=[];

         if($this->status==4)
       { $paymentinfos=Paymentinfo::has('orders')->withCount('orders')->with('paymentmethod')->orderBy('id','desc')->paginate(10);
       }
        else
       { $paymentinfos=Paymentinfo::has('orders')->withCount('orders')->with('paymentmethod')->where('state','=',$this->status)->orderBy('id','desc')->paginate(10);
}
        return view('admin.orders.table',['paymentinfos'=>$paymentinfos])->layout('components.dashborade.index');
    }
}
