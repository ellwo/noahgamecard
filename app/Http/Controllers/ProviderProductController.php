<?php

namespace App\Http\Controllers;

use App\Models\ClientProvider;
use App\Models\Product;
use App\Models\ProviderProduct;
use Illuminate\Http\Request;

class ProviderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //



        return view('admin.provider-products.index');
    }                

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.provider-products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //












        $reqs=[];

        for($i=0; $i<count($request['reqname']??[]); $i++){
            $reqs[]=[
                'name'=>$request['reqname'][$i],
                'lable'=>$request['reqvalue'][$i],
                'def_val'=>$request['reqdef_val'][$i],
                'val'=>$request['reqdef_val'][$i],
                
            ];
        }



      $providerProduct=  ProviderProduct::create([
            'product_id'=>$request['product_id'],
            'price'=>$request['price'],
            'name'=>$request['name'],
            'client_provider_id'=>$request['client_provider_id']??1,
            'active'=>$request['active']??0,
            'reqs'=>$reqs,
              
        ]);


        if($request['active']??0==1){

            $product=Product::find($request['product_id']);
            $product->provider_products()
            ->where('id','!=',$providerProduct->id)->update([
                'active'=>0
            ]);
        }
        return back()->with('status','تم الحفظ بنجاح');
        // $product=Product::find($request['product_id']);




        // $order=$product->orders()->orderBy('created_at','desc')->first();

        // // return dd($order->reqs);

        // foreach($order->reqs as $v){

        //     $lable=$v['lable'];
        //     $value=$v['value'];
            

        // $i=0;
        //     foreach($reqs as $r){
        //         if($r['lable']==$v['lable']){
        //             $reqs[$i]['val']=$value;
        //         }
        //         $i++;
        //     }

        // }





        // $query="";
        // foreach($reqs as $r){
        // $query.=$r['name']."=".$r['val']."&";
        // }


        return dd($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProviderProduct  $providerProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ProviderProduct $providerProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProviderProduct  $providerProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ProviderProduct $providerProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProviderProduct  $providerProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProviderProduct $providerProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProviderProduct  $providerProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProviderProduct $providerProduct)
    {
        //
    }
}
