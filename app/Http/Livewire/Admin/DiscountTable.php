<?php

namespace App\Http\Livewire\Admin;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;

class DiscountTable extends Component
{    public $search='';
    public $deleted_ad='no';
    public $paginate_num=20;

    use WithPagination;
    public function render()
    {

        $discounts=Discount::orderBy('updated_at','desc')->paginate($this->paginate_num);
        return view('admin.discounts.table',['discounts'=>$discounts]);
    }



    public function delete_ad($id)
    {
      $ad=  Discount::find($id);
      if($ad!=null)

      $ad->delete();

      session()->flash('status','تم الحذف بنجاح');

        # code...
    }
}
