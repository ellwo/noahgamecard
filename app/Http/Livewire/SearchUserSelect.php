<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class SearchUserSelect extends Component
{public $query;
    public $contacts;
    public $highlightIndex;
    public $user=-1;
    public $show_drop=0;
    protected  $listeners= ['reset'=>'resetselect'];

    public function mount($user=-1)
    {
        $this->user=$user;
        $this->resetselect();
        if($user!=-1){
        $p=User::find($user);
        $this->query=$p->name??'';
    }
    }





    public function togelshow(){
        $this->show_drop=!$this->show_drop;
    }

    public function resetselect()
    {
        $this->query = '';
        $this->contacts = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->contacts) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
        $this->query=$this->contacts[$this->highlightIndex]['name'];
        $this->user=$this->contacts[$this->highlightIndex]['id'];
    }


    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->contacts) - 1;
            return;
        }
        $this->highlightIndex--;

        $this->query=$this->contacts[$this->highlightIndex]['name'];
        $this->user=$this->contacts[$this->highlightIndex]['id'];
    }


    public function selectContact($user)
    {
        $this->user=$user;
        $this->user=User::find($this->user);


        return dd($this->user);
        $this->show_drop=0;
        // $contact = $this->contacts[$this->highlightIndex] ?? null;
        // if ($contact) {
        //  //   $this->redirect(route('show-contact', $contact['id']));
        // }
    }

    function updatedUser() {

        $this->emitUp('updatedUser',$this->user);
    }
    public function updatedQuery()
    {
        $this->contacts = User::where('name', 'like', '%' . $this->query . '%')
        ->orWhere('username', 'like', '%' . $this->query . '%')
        ->orWhere('email', 'like', '%' . $this->query . '%')
        ->orWhere('phone', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.search-user-select');
    }
}
