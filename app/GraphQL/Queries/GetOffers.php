<?php

namespace App\GraphQL\Queries;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

final class GetOffers
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver










        $user=auth()->user();
        $products=Product::Has('offers')->get();

            if($user!=null){
            $mproduct=$user->order_products()->take(4)->get();
        foreach($mproduct as $p)
        $products[]=$p;
        }

        else{
            $sales = Product::
            leftJoin('orders','products.id','=','orders.product_id')
            ->selectRaw('products.*, COALESCE(sum(orders.qun),0) total')
            ->groupBy('products.id')
            ->orderBy('total','desc')
            ->take(5)
            ->get();




            foreach($sales as $p)
            $products[]=$p;

        }


        return $products;

        return $products;
    }
}
