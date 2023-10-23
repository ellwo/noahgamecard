<?php

namespace App\Observers;

use App\Events\AdminNotifyEvent;
use App\Models\AdminNotify;

class AdminNotifyObserver
{
    /**
     * Handle the AdminNotify "created" event.
     *
     * @param  \App\Models\AdminNotify  $adminNotify
     * @return void
     */
    public function created(AdminNotify $adminNotify)
    {
        //
        event(new AdminNotifyEvent());
    }

    /**
     * Handle the AdminNotify "updated" event.
     *
     * @param  \App\Models\AdminNotify  $adminNotify
     * @return void
     */
    public function updated(AdminNotify $adminNotify)
    {
        //
    }

    /**
     * Handle the AdminNotify "deleted" event.
     *
     * @param  \App\Models\AdminNotify  $adminNotify
     * @return void
     */
    public function deleted(AdminNotify $adminNotify)
    {
        //
    }

    /**
     * Handle the AdminNotify "restored" event.
     *
     * @param  \App\Models\AdminNotify  $adminNotify
     * @return void
     */
    public function restored(AdminNotify $adminNotify)
    {
        //
    }

    /**
     * Handle the AdminNotify "force deleted" event.
     *
     * @param  \App\Models\AdminNotify  $adminNotify
     * @return void
     */
    public function forceDeleted(AdminNotify $adminNotify)
    {
        //
    }
}
