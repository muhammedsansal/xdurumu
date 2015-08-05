<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;
use App\City;
use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use App\Libs\Weather\DataType\WeatherDataAble;
use App\Contracts\Weather\Repository\ICurrentRepository;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use ErrorException;

/**
 * Current Repository Class
 * 
 * @package WeatherForcast
 */
class CurrentRepository extends BaseRepository implements ICurrentRepository
{    
    /**
     * @var \App\WeatherCurrent 
     */
    private $current;

        /**
         * Constructer
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         * @param \App\City                     $city
         * @param \App\WeatherCondition         $condition
         * @param \App\WeatherForeCastResource  $resource
         * @param \App\WeatherCurrent           $current
         */
        public function __construct(
                Cache       $cache, 
                Config      $config,
                City        $city, 
                Condition   $condition, 
                Resource    $resource, 
                Current     $current) {
            
            parent::__construct($cache, $config, $city, $condition, $resource);
            
            $this->current      = $current;                
        }     
        
        /**
         * To add Weather ForeCast Model and Weather Condition model to given Weather Current model
         * via ralationships
         * 
         * 
         * @param \App\WeatherCurrent $current
         * @return array    includes \App\WeatherCurrent 
         */
        private function addResourceAndCondition(Current $current)
        {                
            list($resource, $condition) = $this->getForcastResourceAndCondition(); 
            
            return [ 
                
                $current->foreCastResource()->associate($resource),
                $current->condition()->associate($condition),
            ];
        }
        
        /**
         * To create Instance WeatherMain
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $main
         * @return  \App\WeatherMain
         */
        protected function createWeatherMain(Current $current, WeatherDataAble $main)
        {           
            $attributes = $main->toArray();            
            
            return $current->main()->firstOrCreate($attributes);
        }
        
        /**
         * To create Instance WeatherSys
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $sys
         * @return \App\WeatherSys
         */
        protected function createWeatherSys(Current $current, WeatherDataAble $sys)
        {
            $attributes = $sys->toArray();
            
            return $current->sys()->firstOrCreate($attributes);    
        }
        
        /**
         * To create Instance WeatherWind
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $wind
         * @return \App\WeatherWind
         */
        protected function createWeatherWind(Current $current, WeatherDataAble $wind)
        {
            $attributes = $wind->toArray();
            
            return $current->wind()->firstOrCreate($attributes);    
        }
        
        /**
         * To create Instance WeatherCloud
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $clouds
         * @return \App\WeatherCloud
         */
        protected function createWeatherClouds(Current $current, WeatherDataAble $clouds)
        {
            $attributes = $clouds->toArray();            
            
            return $current->clouds()->firstOrCreate($attributes);    
        }
        
        
       /**
         * To create Instance WeatherRain
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $rain
         * @return \App\WeatherRain
         */
        protected function createWeatherRain(Current $current, WeatherDataAble $rain)
        {
            $attributes = $rain->toArray();          
            
            return $current->rains()->firstOrCreate($attributes);    
        }
        
        /**
         * To create Instance WeatherSnow
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $snow
         * @return \App\WeatherRain
         */
        protected function createWeatherSnow(Current $current, WeatherDataAble $snow)
        {
            $attributes = $snow->toArray();
            
            return $current->snows()->firstOrCreate($attributes);    
        } 
        
        /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return array    [\App\Libs\Weather\DataType\WeatherForecastResource, \App\Libs\Weather\DataType\WeatherCondition]
         */
        public function getForcastResourceAndCondition()
        {
            $resource   = $this->getAttributeOnInportedObject('weather_forecast_resource');
            
            $condition  = $this->getAttributeOnInportedObject('weather_condition');
            
            return [$this->findOrNewResource($resource), $this->findOrNewCondition($condition)];
        } 
        
        
        public function update(array $current)
        {
            
        }
        
        public function delete($cityID)
        {
            
        }        
      
        /**
         * To get Weather Current model
         * 
         * @return \App\WeatherCurrent  
         */
        public function onModel()
        {
            return $this->getMainModel();
        }
        
        /**
         * To get Weather Current model
         * 
         * @return \App\WeatherCurrent 
         */
        public function getMainModel()                 
        {
            return $this->current;            
        }     
        
        /**
         * To start all import proccess
         * 
         * @return \App\WeatherCurrent
         * @throws \ErrorException
         */
        protected function startImport()
        {            
            $new        = $this->firstOrCreateWeatherCurrent(array());
            
            $results    = $this->importAllRelationships($new);         
            
            $new->source_updated_at = $this->getAttributeOnInportedObject('source_updated_at');
                        
            if ($new->save()) { return $new; }
            
            throw new ErrorException('Weather Current model can not be created !');   
        }
        
        /**
         * To get first one or if it is not exsits, create one
         * 
         * @param array $attributes
         * @return \App\WeatherCurrent
         */
        private function firstOrCreateWeatherCurrent(array $attributes)
        {          
            return $this->getSelectedCity()->weatherCurrent()->firstOrCreate($attributes);            
        }
        
        /**
         * to attach all childs model to App\WeatherCurrent model
         * 
         * @param App\WeatherCurrent $current
         * @return array    results
         */
        protected function importAllRelationships(Current $current)
        {
            $results    = $this->addResourceAndCondition($current);
            $results2   = $this->addOtherAllRelationships($current);            
            
            return  array_merge($results, $results2);
        }
       
}