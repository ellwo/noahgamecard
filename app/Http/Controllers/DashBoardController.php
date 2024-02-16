<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use App\Models\Paymentinfo;
use App\Models\Product;
use App\Models\RassedActevity;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DashBoardController extends Controller
{





  public function index()
  {

    // $paymentinfo = Paymentinfo::find(121);

    // RassedActevity::create([
    //   'paymentinfo_id' => 121,
    //   'rassed_id' => $paymentinfo->rassed_actevity->rassed_id,
    //   'amount' => $paymentinfo->rassed_actevity->amount,
    //   'camount' => 0.0,
    //   'coin_id' => $paymentinfo->rassed_actevity->coin_id,
    //   'code' => $paymentinfo->rassed_actevity->code
    // ]);



    $users_count = User::count();

    $orders_done = Paymentinfo::has('orders')->where('state', '=', 2)->count();

    $unread_orders_count = Paymentinfo::has('orders')->where('state', '=', 0)
      ->orWhere('state', '=', 1)->count();


    $d_count = Department::count();
    $products_count = Product::count();
    $unreaded_messages = Contact::where('reply', '=', null)->orWhere('reply', '=', '')->count();
    $unread__veed_count = RassedActevity::where('amount', '=', 0)
    ->whereHas('paymentinfo', function ($q) {
      $q->where('state', '!=', 3)->where('state', '!=', 2);
    })->count();


    $response = Http::get("https://ehsanadminpanel.noahgamecard.com/");



    return view('dashboard', [
      'orders_done' => $orders_done,
      'products_count' => $products_count,
      'unreaded_messages' => $unreaded_messages,
      'unread__orders_count' => $unread_orders_count,
      'users_count' => $users_count,
      'd_count' => $d_count,
      'unread__veed_count' => $unread__veed_count
    ]);
  }
}
