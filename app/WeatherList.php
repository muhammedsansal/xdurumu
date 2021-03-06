<?php

namespace App;

use Carbon\Carbon;
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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
     public $timestamps = false;
                  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['source_updated_at', ''];
    
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
         * To delete Weather Condition models belongs to this model
         * 
         * @return int
         */
        protected function deleteConditions()
        {   
            $ids = $this->conditions()->get()->map(function($item){ return $item->id; });
            
            return $this->conditions()->detach($ids->toArray());
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
         * To delete Weather Main model belongs to this model
         * 
         * @return bool|null
         */
        protected function deleteMain()
        {
            $model = $this->main;
            
            if (is_null($model)) { return; }
            
            return $model->delete();
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
         * To delete Weather Wind model belongs to this model
         * 
         * @return bool|null
         */
        protected function deleteWind()
        {
            $model = $this->wind;
            
            if (is_null($model)) { return; }
            
            return $model->delete();
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
         * To delete Weather Rain model belongs to this model
         * 
         * @return bool|null
         */
        protected function deleteRain()
        {
            $model = $this->rain;
            
            if (is_null($model)) { return; }
            
            return $model->delete();
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
         * To delete Weather Snow model belongs to this model
         * 
         * @return bool|null
         */
        protected function deleteSnow()
        {
            $model = $this->snow;
            
            if (is_null($model)) { return; }
            
            return $model->delete();
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
        
        /**
         * To delete Weather Clouds model belongs to this model
         * 
         * @return bool|null
         */
        protected function deleteClouds()
        {
            $model = $this->clouds;
            
            if (is_null($model)) { return; }
            
            return $model->delete();
        }   
        
        /**
         * To delete all relations
         * 
         * @return void
         */
        protected function deleteAllRelations()
        {
            $this->deleteClouds();
            $this->deleteConditions();
            $this->deleteMain();            
            $this->deleteRain();
            $this->deleteSnow();            
            $this->deleteWind();           
        }

        /**
         * Deletes all relations
         * 
         * @return void
         */
        public static function boot()
        {
            parent::boot();  
            
            static::deleted(function($model) {
                
                $model->deleteAllRelations();
            });       
        }
        
        /**
         * To get names of all relations 
         * 
         * @return array
         */
        public function getNameOfRelations()
        {
            return [
                'main',
                'clouds',
                'snow',
                'rain',
                'wind',
                'conditions',
            ];
        }
        
        /**
         * To get hour:minute of time
         * 
         * @return string
         */
        public function hourMinute()
        {
            $time = Carbon::createFromTimestampUTC($this->dt);
            
            if ( $time->minute !== 0) {                
            
                $time->minute = 0;              
            }
            
            $timeStr = $time->toTimeString();  

            return str_limit($timeStr, 5, '');
        }
        
        /**
         * To get hour:minute of time
         * 
         * @return \Carbon\Carbon
         */
        public function carbonForDt()
        {
            $time = Carbon::createFromTimestampUTC($this->dt);
            
            setlocale(LC_ALL, 'tr_TR.utf8');  
            
            $time->setLocale('tr');                        
           
            return $time;            
        }
}


