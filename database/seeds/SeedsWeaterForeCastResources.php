<?php

use Illuminate\Database\Seeder;
use App\WeatherForeCastResource;

class SeedsWeaterForeCastResources extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->addOpenWeatherMapResource();
        
    }
    
    private function addOpenWeatherMapResource()
    {
        
        $openWeatherMap = [
            
            'name'                  => 'openweathermap',
            'description'           => 'Current weather conditions in cities for world wide',
            'url'                   => 'openweathermap.org',
            'api_url'               => 'api.openweathermap.org/data/2.5/',            
            'enable'                => 1,
            'paid'                  => 0,
            'priority'              => 0,
            'apiable'               => true,           
        ];
        
        $resource  = new WeatherForeCastResource($openWeatherMap);
        
        if ($resource->save()) {
            
            $this->command->info($openWeatherMap['name'] . ' weather forecast resource is saved. ');            
            return true;
        }
        
        $this->command->info($openWeatherMap['name'] . ' weather forecast resource is not saved! ');
        
        return false;
    }
}
