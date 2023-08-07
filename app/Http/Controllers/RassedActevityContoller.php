<?php

namespace App\Http\Controllers;

use App\Models\Paymentinfo;
use App\Models\RassedActevity;
use Illuminate\Http\Request;

class RassedActevityContoller extends Controller
{



    public function __construct()
{
    $this->middleware(['permission:ادارة التغذية']);
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        return view('admin.rassed.index');

        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function show(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function edit(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return \Illuminate\Http\Response
     */
    public function destroy(RassedActevity $rassedActevity)
    {
        //
    }
}
