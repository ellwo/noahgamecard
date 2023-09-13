<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;


class ClientsTable extends Component
{
    use WithPagination;

    public $search="",
    $paginate_num=20,
    $delete_orderid=-1;
    public function render()
    {
        $users=User::has('rassed_acetvities')
        ->where(function($q){
            $q->where('name','LIKE','%'.$this->search.'%')
            ->orWhere('phone','LIKE','%'.$this->search.'%')
            ->orWhere('username','LIKE','%'.$this->search.'%');
        })

        ->withSum(['rassed_acetvities:amount as pay_sum' =>
        function (Builder $query) {
            $query->where('amount','<',0);
        }])->withSum(['rassed_acetvities:amount as veed_sum' =>
        function (Builder $query) {
            $query->where('amount','>',0)->whereHas('paymentinfo',function($q){
                $q->where('state','=',2);
            });
        }])->paginate($this->paginate_num);


        return view('admin.clients.table',[
            'users'=>$users
        ]);
    }
}
