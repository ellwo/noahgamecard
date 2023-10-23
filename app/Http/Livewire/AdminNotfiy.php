<?php

namespace App\Http\Livewire;

use App\Models\AdminNotify;
use Livewire\Component;

class AdminNotfiy extends Component
{
    public $unread_count=0;
    public $notifs=[];
 
    public function render()
    {

               
        $this->unread_count=AdminNotify::where('readed','=',0)->count();
        $this->notifs=AdminNotify::orderBy('created_at','desc')->get();
 
        return view('livewire.admin-notfiy')->layout('components.dashborade.index');
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
