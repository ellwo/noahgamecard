<?php

namespace App\Events;

use App\Jobs\TopOnlinePayByAPIJob;
use App\Models\RassedActevity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class RassedActevityCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public RassedActevity $rassedActevity;
    public function __construct(RassedActevity $rassedActevity)
    {
        $this->rassedActevity=$rassedActevity;
        //


        Artisan::call('queue:work --stop-when-empty');

        // if ($this->rassedActevity->paymentinfo->orders->count() > 0) {
        //     $product = $this->rassedActevity->paymentinfo->order->product;

        //     if ($product->provider_product->count() > 0) {

        //         $clientProvider = $product->provider_product()->first()->client_provider;

        //         if ($clientProvider->id == 1) {

        //             // $this->paymentinfo=$this->rassedActevity->paymentinfo;


        //             TopOnlinePayByAPIJob::dispatch($rassedActevity);

        //            // $this->paymentinfo = $this->rassedActevity->paymentinfo;
        //            // $this->handle_process();
        //             //dispatch(new TopOnlinePayByAPIJob($this->rassedActevity->paymentinfo));
        //         }
        //     }
        // }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
