<?php

namespace App\Http\Livewire\Admin;

use App\Models\ClientProvider;
use App\Models\Product;
use App\Models\ProviderProduct;
use Livewire\Component;

class ProviderProductEditForm extends Component
{
    public Product $product;
    public $product_id=-1;
    public $provider_id=-1;
    public $req_count=1;
    public $pr_product_id=1;
    protected $rules=[
        'product.name'=>'required'
    ];

    public function  mount($deptid="all",$search="",$provider_id=1,$pr_product){
        $this->product =Product::first();
        $this->product_id=$this->product_id;
       $this->provider_id=$provider_id;
       $this->pr_product_id=$pr_product;
      
       $pr_provider=ProviderProduct::find($this->pr_product_id);
       $this->product=$pr_provider->product;
      $this->product_id=$pr_provider->product->id;
 
    }
    public function render()
    {
    

        $provider=ClientProvider::active()->get();
        $pr_provider=ProviderProduct::find($this->pr_product_id);
        //$this->product=$pr_provider->product;
       // $this->product_id=$pr_provider->product->id;

        $products=Product::active()->get();
        return view('admin.provider-products.edit-form',
    ['products'=>$products,
'providers'=>$provider,
'pr_product'=>$pr_provider]);
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
