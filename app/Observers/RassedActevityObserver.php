<?php

namespace App\Observers;

use App\Events\RassedActevityCreated;
use App\Jobs\TopOnlinePayByAPIJob;
use App\Models\RassedActevity;
use Exception;

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



            try{
                TopOnlinePayByAPIJob::dispatch($rassedActevity);
            // event(new RassedActevityCreated($rassedActevity));
        }catch(Exception $e){

        }

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
