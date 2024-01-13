<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{



    public function __construct()
{
    // $this->middleware(['permission:ادارة العروض']);
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.ad.ad-index-table');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.ad.ad-form-create');
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
        $this->validate($request,[
            'product_id'=>['required','exists:products,id'],
            'to_date'=>['required','date'],
            'p_dic'=>['required','dimensions']
        ]);

        $offer=Offer::create([
            'product_id'=>$request['product_id'],
            'to_date'=>$request['to_date'],
            'p_dic'=>$request['p_dic']
        ]);

        return redirect()->route('offers')->with('status','تم الحفظ بنجاح');

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
        return view('admin.ad.ad-edit',['offer'=>$offer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //

        $this->validate($request,[
            'product_id'=>['required','exists:products,id'],
            'to_date'=>['required','date'],
            'p_dic'=>['required']
        ]);

        $offer->update([
            'product_id'=>$request['product_id'],
            'to_date'=>$request['to_date'],
            'p_dic'=>$request['p_dic']
        ]);

        return redirect()->route('offers')->with('status','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
