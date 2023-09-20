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
        $provider=new ClientProvider([
            'name'=>'toponline',
            'phone'=>'775212843'
        ]);
        $products=Product::all();
        return view('admin.provider-products.create',[
            'products'=>$products,
            'provider'=>$provider
        ]);
    }                

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


        $product=Product::find($request['product_id']);




        $order=$product->orders()->orderBy('created_at','desc')->first();

        // return dd($order->reqs);

        foreach($order->reqs as $v){

            $lable=$v['lable'];
            $value=$v['value'];
            

        $i=0;
            foreach($reqs as $r){
                if($r['lable']==$v['lable']){
                    $reqs[$i]['val']=$value;
                }
                $i++;
            }

        }





        $query="";
        foreach($reqs as $r){
        $query.=$r['name']."=".$r['val']."&";
        }


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
