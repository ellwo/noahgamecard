<?php

namespace App\Jobs;

use App\Models\Paymentinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TopOnlinePayByAPIJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public Paymentinfo $paymentinfo;
    public function __construct(Paymentinfo $paymentinfo)
    {
        $this->paymentinfo=$paymentinfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {



     }





     function genurateToken()
     {
        # code...
        
     }
     
}
