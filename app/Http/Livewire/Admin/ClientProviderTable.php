<?php

namespace App\Http\Livewire\Admin;

use App\Models\ClientProvider;
use App\Models\Coin;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ClientProviderTable extends Component
{
    use WithPagination;

    public $search="",
    $paginate_num=20,
    $delete_orderid=-1;
    public $coin=null;
    public function render()
    {

        $this->coin=Coin::where('nickname','=','R.Y')->first();
        $users=ClientProvider::where(function($q){
            $q->where('name','LIKE','%'.$this->search.'%')
            ->orWhere('phone','LIKE','%'.$this->search.'%')
            ->orWhere('email','LIKE','%'.$this->search.'%');
        })

        ->
        // withSum(['rassed_acetvities:amount as pay_sum' =>
        // function (Builder $query) {
        //     $query->where('amount','<',0)
        //     ->whereHas('paymentinfo',function($q){
        //         $q->where('state','=',2)->orWhere('state','=',1);
        //     });
        // }])->
        /*
        withSum(['rassed_acetvities:amount as veed_sum' =>
        function (Builder $query) {
            $query->where('amount','>',0)->whereHas('paymentinfo',function($q){
                $q->where('state','=',2);
            });
        }])->
         */
        paginate($this->paginate_num);


        return view('admin.client-providers.table',[
            'users'=>$users
        ]);
    }



    public function active_client($c_id)
    {
        $client=ClientProvider::find($c_id);


        //return dd($client->pay_sum());
        $client->update([
            'active'=>!$client->active
        ]);
    }
    public function deletePro($c_id)
    {
        $client=ClientProvider::find($c_id);


        //return dd($client->pay_sum());
        $client->update([
            'active'=>!$client->active
        ]);
        $client->provider_products()->active()->get()->each(function($p){
            $p->update([
                'active'=>false
            ]);
        });
        $this->delete_orderid=-1;
        # code...
    }
    

    function refresh_page(){
        $this->resetPage();
        $this->page=1;
        $this->search="";

        Cache::forget('rassed');

    }
}
