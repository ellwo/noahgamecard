<?php

namespace App\Http\Livewire;

use App\Models\AdminNotify;
use Livewire\Component;
use Livewire\WithPagination;

class AdminNotfiy extends Component
{
    use WithPagination;
    public $unread_count=0;
    // public $notifs;
    // public $readed_notifs;
    public function render()
    {

        $readed_notifs=AdminNotify::where('readed','=',1)->orderBy('created_at','desc')->paginate(20);
        $notifs=AdminNotify::where('readed','=',1)->orderBy('created_at','desc')->paginate(20);
        $this->unread_count=$notifs->total();

        return view('livewire.admin-notfiy',[
            'notifs'=>$notifs,
            'readed_notifs'=>$readed_notifs
        ])->layout('components.dashborade.index');
    }



    public function click_item($id)
    {
        $n=AdminNotify::find($id);

        $n->update([
            'readed'=>1
        ]);

        redirect()->to($n->link);

        # code...
    }
}
