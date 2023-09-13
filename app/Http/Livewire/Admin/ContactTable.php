<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class ContactTable extends Component
{
    use WithPagination;
    public $paginate_num=20;

    public function render()
    {
        $contacts=Contact::orderBy('created_at')->paginate($this->paginate_num);
        return view('admin.contact.contact-table',['contacts'=>$contacts]);
    }
}
