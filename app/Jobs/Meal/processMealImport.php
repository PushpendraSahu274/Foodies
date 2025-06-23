<?php

namespace App\Jobs\Meal;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class processMealImport implements ShouldQueue
{
    use Dispatchable, Queueable;
    //Dispatchable -> 
    //Queueable -> 

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
