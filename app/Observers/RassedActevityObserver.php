<?php

namespace App\Observers;

use App\Jobs\TopOnlinePayByAPIJob;
use App\Models\RassedActevity;

class RassedActevityObserver
{
    /**
     * Handle the RassedActevity "created" event.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return void
     */
    public function created(RassedActevity $rassedActevity)
    {

        if(env('APP_ENV','local') == 'local')
        {

            if($rassedActevity->paymentinfo->orders->count()>0){
                $product=$rassedActevity->paymentinfo->order->product;

                if($product->provider_product->count()>0){
    
                    $clientProvider=$product->provider_product()->first()->client_provider;
    
                    if($clientProvider->id==1){
                        
                        dispatch(new TopOnlinePayByAPIJob($rassedActevity->paymentinfo));
                    }
                    
    
                }
    
            }
    

        }
        
        //
    }

    /**
     * Handle the RassedActevity "updated" event.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return void
     */
    public function updated(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Handle the RassedActevity "deleted" event.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return void
     */
    public function deleted(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Handle the RassedActevity "restored" event.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return void
     */
    public function restored(RassedActevity $rassedActevity)
    {
        //
    }

    /**
     * Handle the RassedActevity "force deleted" event.
     *
     * @param  \App\Models\RassedActevity  $rassedActevity
     * @return void
     */
    public function forceDeleted(RassedActevity $rassedActevity)
    {
        //
    }
}
