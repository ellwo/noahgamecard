<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ad;
use Livewire\Component;
use Livewire\WithPagination;

class AdTablebanners extends Component
{

    public $search='';
    public $deleted_ad='no';
    use WithPagination;
    public function render()
    {

        $ads=Ad::orderBy('updated_at','desc')->paginate(5);
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
