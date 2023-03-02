<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DiscountController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.discounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles=Role::all();
        return view('admin.discounts.create',['roles'=>$roles]);
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
            'role_id'=>['required','exists:roles,id'],
            'dis_persint'=>['required']
        ]);

        $offer=Discount::create([
            'role_id'=>$request['role_id'],
            'dis_persint'=>$request['dis_persint']

        ]);

        return redirect()->route('discount')->with('status','تم الحفظ بنجاح');

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
        $roles=Role::all();
        return view('admin.discounts.edite',['discount'=>$discount,'roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        //

        $this->validate($request,[
            'role_id'=>['required','exists:roles,id'],
            'dis_persint'=>['required']
        ]);

        $discount->update([
            'role_id'=>$request['role_id'],
            'dis_persint'=>$request['dis_persint']
        ]);

        return redirect()->route('discount')->with('status','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $offer)
    {
        //
    }
}
