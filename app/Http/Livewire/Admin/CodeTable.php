<?php

namespace App\Http\Livewire\Admin;

use App\Models\PhoneCode;
use Livewire\Component;
use Livewire\WithPagination;

class CodeTable extends Component
{

    public $search='';
    public $deleted_ad='no';
    public $paginate_num=20;

    use WithPagination;
    public function render()
    {

        $codes=PhoneCode::orderBy('created_at','desc')
        ->where('phone','LIKE','%'.$this->search."%")
        ->paginate($this->paginate_num);
        return view('livewire.admin.code-table',[
            'codes'=>$codes

        ])->layout('components.dashboard.index');
    }

    public function updatedSearch(){
        $this->resetPage();
    }
}
