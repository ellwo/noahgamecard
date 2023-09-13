<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coin;
use Livewire\Component;

class ManageCoinTable extends Component
{
    public function render()
    {
        $coins=Coin::where('main_coin','=',0)->get();
        return view('admin.coins.create',[
            'coins'=>$coins
        ]);
    }
}
