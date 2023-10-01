<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{


   public $dateorder="no";
   public $priceorder="no";
   public $search="";
   public $countorder="DESC";
   public $deptid;
   public $editproid="no";
   public $deleteproid="no";
   public $paginate_num=20;

    /**
     * @param string $deleteproid
     */
    public function setDeleteproid($deleteproid)
    {
        $this->deleteproid = $deleteproid;
    }

    public function getQueryString()
    {
        return ['search'=>$this->search,'page'=>$this->page,'deptid'=>$this->deptid]; // TODO: Change the autogenerated stub
    }

    protected $queryString=['search','page','deptid'];

    public function  mount($deptid="all",$search=""){


       $this->deptid=$deptid;
       $this->search=$search;

       if(isset($_GET['deptid']) && $_GET['deptid']!=null)
           $this->deptid=$_GET['deptid'];
   }



   use WithPagination;
    public function render()
    {



        if($this->deptid=="all") {





            if($this->dateorder=="no" && $this->priceorder=="no"){

                $products = Product::where("name", "LIKE", "%" . $this->search . "%")
                    ->orderByDesc("updated_at")->withCount('orders as orders_count')->paginate($this->paginate_num);
            }
            else if($this->priceorder!="no"){
                $this->dateorder="no";
                $products = Product::where("name", "LIKE", "%" . $this->search . "%")
                    ->orderBy("price",$this->priceorder)->withCount('orders as orders_count')->paginate($this->paginate_num);
            }
            else if($this->dateorder!="no"){
                $this->priceorder="no";
                $products = Product::where("name", "LIKE", "%" . $this->search . "%")
                    ->orderBy("updated_at",$this->dateorder)->withCount('orders as orders_count')->paginate($this->paginate_num);
            }




            return view('admin.products.product-table', compact('products'))->layout('components.dashborade.index');
        }
        else {
            if($this->dateorder=="no" && $this->priceorder=="no"){

                $products = Product::where("department_id",$this->deptid)->where("name", "LIKE", "%" . $this->search . "%")
                    ->orderByDesc("updated_at")->withCount('orders as orders_count')->paginate($this->paginate_num);
            }
            else if($this->priceorder!="no"){
                $products = Product::where("department_id",$this->deptid)->where("name", "LIKE", "%" . $this->search . "%")
                    ->orderBy("price",$this->priceorder)->withCount('orders as orders_count')->paginate($this->paginate_num);
            }
            else if($this->dateorder!="no"){
                $products = Product::where("department_id",$this->deptid)->where("name", "LIKE", "%" . $this->search . "%")
                    ->orderBy("updated_at",$this->dateorder)->withCount('orders as orders_count')->paginate($this->paginate_num);
            }




            return view('admin.products.product-table', compact('products'))->layout('components.dashborade.index');

        }
    }
    public function updateDeptid(){
        $this->resetPage();
    }



    public function tlogdate(){
        if($this->dateorder=="no" || $this->dateorder=="DESC"){
            $this->dateorder="ASC";
            $this->priceorder="no";
        }
        else{
            $this->dateorder="DESC";
            $this->priceorder="no";
        }
    }

    public function tlogprice(){
        if($this->priceorder=="no" || $this->priceorder=="DESC"){
            $this->priceorder="ASC";
            $this->dateorder="no";
        }
        else{
            $this->priceorder="DESC";
            $this->dateorder="no";
        }
    }



    public function deletePro($id){
        $product=Product::find($id);

        $product->update([
            'active'=>!$product->active
        ]);

        // if($product->countoforders()>0)
        // {

        //     $product->orders()->delete();
        //     $product->normalorders()->delete();
        //     $product->cartorders()->delete();
        //     $product->cartordernromals()->delete();

        // }

        // $product->parts()->detach();
        // $product->delete();
        // session()->flash('statt','ok');
        // session()->flash('message','تم الحذف');

        $this->deleteproid="no";


    }

    public function editpro($id){

        $this->editproid=$id;

        redirect()->route("admin.productsaddnew",["editproid"=>$id]);

        //$this->emit("");
      //  $this->render();

    }
    public function cancelEdit(){
        $this->editproid="no";
    }
}
