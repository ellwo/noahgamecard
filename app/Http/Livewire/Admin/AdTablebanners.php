<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ad;
use Livewire\Component;
use Livewire\WithPagination;

class AdTablebanners extends Component
{

    public $search='';
    public $deleted_ad='no';
    public $paginate_num=20;

    use WithPagination;
    public function render()
    {

        $ads=Ad::orderBy('updated_at','desc')->paginate($this->paginate_num);
       // return dd($ads);
        return view('admin.adbanners.ad-table',['ads'=>$ads]);
    }



    public function delete_ad($id)
    {
      $ad=  Ad::find($id);
      if($ad!=null)
      $ad->delete();

      session()->flash('status','تم الحذف بنجاح');

        # code...
    }
}
