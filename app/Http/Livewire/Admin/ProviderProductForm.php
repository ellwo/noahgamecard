<?php

namespace App\Http\Livewire\Admin;

use App\Models\ClientProvider;
use App\Models\Product;
use Livewire\Component;

class ProviderProductForm extends Component
{

    public Product $product;
    public $product_id=-1;
    public $provider_id=-1;
    public $req_count=1;
    protected $rules=[
        'product.name'=>'required'
    ];

    public function  mount($deptid="all",$search="",$provider_id=1){
        $this->product =Product::active()->first();
        $this->product_id=$this->product_id;
       $this->provider_id=$provider_id;
      
 
    }
    public function render()
    {
    

        $provider=ClientProvider::active()->get();
        $products=Product::active()->wheredoesntHave('provider_products',function($q){
            $q->where('client_provider_id','=',$this->provider_id);
        })->get();
        return view('admin.provider-products.create-form',
    ['products'=>$products,
'providers'=>$provider]);
    }


    function updatedProductId()
    {
        # code...
        $this->product=Product::find($this->product_id);
        //return dd($this->product_id);
//        $this->req_count=0;
    }

    public function req_count_plus()
    {
        # code...
        $this->req_count++;
    }
}
