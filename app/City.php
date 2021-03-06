<?php

namespace App;

use App\CacheAbleEloquent;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/**
 * App\City
 *
 * 
 */
class City extends  CacheAbleEloquent implements SluggableInterface
{
    
    use SoftDeletes, SluggableTrait;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'latitude', 'longitude', 'country', 'open_weather_map_id', 'priority'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['open_weather_map_id', 'deleted_at', 'enable', 'created_at', 'updated_at', 'sort_order'];
    
    /**
     * Slug options
     *
     * @var array 
     */
    protected $sluggable = [
            
            'build_from' => 'name',
            'save_to'    => 'slug',
    ];
    
    
    /**
     * Tukish character to convert  the slug
     * 
     * @var array
     */
    protected $slugRules = [ 
        
            'Ö' => 'o',
            'ö' => 'o',
            'Ü' => 'u',                    
            'ü' => 'u',                          
            'Ğ' => 'G',
            'İ' => 'I',
            'Ş' => 'S',
            'ç' => 'c',
            'ğ' => 'g',
            'ı' => 'i',
            'ş' => 's',
            'â' => 'a',
    ];
    
        /**
         * Defining one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function weatherCurrent()
        {
            return  $this->hasOne('App\WeatherCurrent', 'city_id', 'id');        
        }
        
        /**
         * Defining one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function weatherHourlyStat()
        {
            return  $this->hasOne('App\WeatherHourlyStat', 'city_id', 'id');      
        }
        
       /**
         * To get weather daily stat model in relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function weatherDailyStat()
        {
            return  $this->hasOne('App\Weather\DailyStat', 'city_id', 'id');        
        }
        
        /**
         * To get names of all relations 
         * 
         * @return array
         */
        public function getNameOfRelations()
        {
            return [
                'weatherDailyStat',
                'weatherHourlyStat',
                'weatherCurrent',
            ];
        }
    
        /**
        * Scope a query to only enebled.
        *
        * @return \Illuminate\Database\Eloquent\Builder
        */
        public function scopeEnable($query)
        {
           return $query->where('enable', 1);
        }

        /**
         * Scope a query to only include users of a given type.
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeOfCountry($query, $code)
        {
            return $query->where('country', $code);
        }        
        
        /**
         * To set Priority attribute
         * 
         * @param int $value
         * @return int
         */
        public function setPriorityAttribute($value)
        {
            $num = (integer) $value;
            
            switch($num) {
                
                case $num < 0 : return $this->attributes['priority'] = 0;
                    
                case $num >= 4 : return $this->attributes['priority'] = 4;             
            }
            
            return $this->attributes['priority'] = $num;
       }
       
       /**
        * To increase priority attribute by one
        * 
        * @return type
        */
       public function incPriority()
       {
           return $this->increment('priority');
       }
       
       /**
        * To decrease priority attribute by one
        * 
        * @return type
        */
       public function decPriority()
       {
           return $this->decrement('priority');
       }
       
       /**
        * Determine if it has weather current data
        * 
        * @return bool
        */
       public function hasWeatherCurrent()
       {           
           return ! $this->weatherCurrent()->getQuery()->get()->isEmpty();
       }
       
       /**
        * Determine if it has weather hourly data
        * 
        * @return bool
        */
       public function hasWeatherHourlyStat()
       {           
           return ! $this->weatherHourlyStat()->getQuery()->get()->isEmpty();
       }
       
       /**
        * Determine if it has weather daily data
        * 
        * @return bool
        */
       public function hasWeatherDailyStat()
       {           
           return ! $this->weatherDailyStat()->getQuery()->get()->isEmpty();
       }   
       
       /**
        * Determine if it has  current and daily weather data 
        * 
        * @return bool
        */
       public function weatherDataIsReady()
       {
           return $this->hasWeatherCurrent() && $this->hasWeatherDailyStat();
       }      
       
       /**
        * Addinf new rules by overloading method on the trait
        * 
        * @return \Cocur\Slugify\Slugify
        */
        protected function getSlugEngine() 
        {
           $engine  = new Slugify();
           
           $rules   = $this->slugRules;

           $engine->addRules($rules);           

           return $engine;
        }
}