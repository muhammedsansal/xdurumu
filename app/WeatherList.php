<?php

namespace App;


use App\CacheAbleEloquent as CacheAble;

/**
 * Weather List Model is created for CRUD jobs to manage lists of weather hourly and daily data..
 * 
 * @package WeatherForCast
 */
class WeatherList extends CacheAble
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_lists';   
                  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['source_updated_at', 'td'];
    
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function listable()
        {
            return $this->morphTo('listable', 'listable_type', 'listable_id');
        }     
        
         /**
         * To define an many to many polymorphic relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
         */
        public function conditions()
        {
            return $this->morphToMany('App\WeatherCondition', 'weather_condition_able', 'weather_condition_ables');            
        }    

        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function main() 
        {            
            return $this->morphOne('App\WeatherMain', 'mainable', 'mainable_type', 'mainable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function wind() 
        {            
            return $this->morphOne('App\WeatherWind', 'windable','windable_type', 'windable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function rain() 
        {            
            return $this->morphOne('App\WeatherRain', 'rainable','rainable_type', 'rainable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function snow() 
        {            
            return $this->morphOne('App\WeatherSnow', 'snowable','snowable_type', 'snowable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function clouds() 
        {            
            return $this->morphOne('App\WeatherCloud', 'cloudsable', 'cloudsable_type', 'cloudsable_id');
        }
        
}
