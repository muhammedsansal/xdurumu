<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\City;
use App\Repositories\Weather\CurrentRepository as CurrentRepo;

/**
 * This Job updated weather current data for passed city
 * 
 */
class UpdateWeatherCurrent extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var \App\Repositories\Weather\CurrentRepository
     */
    private $currentRepo;
            

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct(City $city /*CurrentRepo $current*/)
        {
            $this->city         = $city;
            
            //$this->currentRepo  = $current;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            
            \Log::info($this->city->name);            
        }
}