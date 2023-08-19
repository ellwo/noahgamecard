<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use App\Models\Paymentinfo;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashBoardController extends Controller
{


  public function index(){


    $users_count=User::count();

    $orders_done=Paymentinfo::has('orders')->where('state','=',3)->count();
    $unread_orders_count=Paymentinfo::has('orders')->where('state','=',0)
    ->orWhere('state','=',1)->count();
    $d_count=Department::count();
    $products_count=Product::count();
   $unreaded_messages=Contact::where('reply','=',null)->orWhere('reply','=','')->count();


    return view('dashboard',[
        'orders_done'=>$orders_done,
        'products_count'=>$products_count,
        'unreaded_messages'=>$unreaded_messages,
        'unread__orders_count'=>$unread_orders_count,
        'users_count'=>$users_count,
        'd_count'=>$d_count
    ]);
    }
}
