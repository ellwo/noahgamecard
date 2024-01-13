<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Paymentinfo;
use App\Models\Paymentmethod;
use App\Models\Processetoken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class PaymentmethodController extends Controller
{
    

   public  function index(Request $request){


    $pays=Paymentinfo::
    with('paymentmethod:id,name')->with('rassed_actevity')
    ->where('state','=',2)->whereHas('rassed_actevity',function($r){
        $r->where('amount','>',0);
    })->get()->groupBy(['paymentmethod.name']);

    $de=[];
    foreach ($pays as $key => $value) {
        # code...
        $de[]=[
            'name'=>$key,
            'veed_sum'=>$pays[$key]->sum('total_price')
        ];

    }


    return view('admin.paymentmethods.report',[
        'pays'=>$de
    ]);

   }







   public function create(){

   }















}
