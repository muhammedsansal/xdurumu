<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Sys
 * 
 * @package WaetherForcast
 */
class WeatherSys extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_sys';
    
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
    protected $fillable = ['country', 'sunrise', 'sunset']; 
    
        
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['sysable_type', 'sysable_id'];
            
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function sysable()
        {
            return $this->morphTo('sysable', 'sysable_type', 'sysable_id');
        }
    
}
