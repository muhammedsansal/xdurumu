<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\City;


class CityModelTest extends TestCase
{
    
   use DatabaseMigrations, DatabaseTransactions;
    
    
    private $cityJsonExampleData = '{"_id":703363,"name":"Laspi","country":"UA","coord":{"lon":33.733334,"lat":44.416668}}';
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {
           
            $city = factory(City::class)->make();          
        }
        
        
        public function testSimpleTwo() 
        { 
            $one    = json_decode($this->cityJsonExampleData);           
            
            $attr = [
                
                'name'      => $one->name,
                'country'   => $one->country,
                'latitude'  => $one->coord->lat,
                'longitude' => $one->coord->lon,
                'open_weather_map_id' =>  $one->_id,        
            ];
            
            $city = factory(City::class)->make($attr);   
            
            $this->assertEquals($one->name, $city['name']);
            $this->assertEquals($one->country, $city['country']);
            $this->assertEquals($one->coord->lat, $city['latitude']);
            $this->assertEquals($one->coord->lon, $city['longitude']);
            $this->assertEquals($one->_id, $city['open_weather_map_id']);  
            // generating slug 
            $city->sluggify();
            
            $this->assertEquals($city['slug'], 'laspi');
        }
        
        public function testSlugBugWhenUseTurkishCharacter() 
        { 
                        
            $attr = [
                
                'name'      => 'Gümüşhane',             
            ];
            
            $city = factory(City::class)->make($attr);          
        
            // generating slug 
            $city->sluggify();
            
            /**
             * TODO:
             *  -There is a bug about generating slug
             *      https://github.com/cviebrock/eloquent-sluggable/issues/164
             *  
             */
            $this->assertEquals($city['slug'], 'gumushane');
        }
        
        /**
         * 
         * @param array $attributes
         * @return \App\City
         */
        public function createNewCity(array $attributes = [])
        {
            return factory(City::class)->make($attributes);            
        }        
        
        public function testRelationship()
        {
            $one = $this->createNewCity();
            
            $this->assertInstanceOf('App\WeatherCurrent', $one->weatherCurrent()->getRelated());
            $this->assertInstanceOf('App\WeatherHourlyStat', $one->weatherHourlyStat()->getRelated());
            $this->assertInstanceOf('App\WeatherMain', $one->weatherCurrent()->getRelated()->main()->getRelated());  
        }
        
        public function testSimpleCRUD()
        {
            $one = $this->createNewCity();
            
            $this->assertTrue($one->save());     
        }
        
        
        public function testHasRelations()
        {
            $one = $this->createNewCity();
            
            $this->assertTrue($one->save());            
            
            $this->assertFalse($one->hasWeatherCurrent());
            
            $this->assertFalse($one->hasWeatherHourlyStat());
            
            $this->assertFalse($one->hasWeatherDailyStat());        
            
            $current  = $one->weatherCurrent()->create([]);
            
            $this->assertNotNull($current);
            
            $this->assertTrue($one->hasWeatherCurrent());
            
            $hourly = $one->weatherDailyStat()->create([]);
            
            $this->assertNotNull($hourly);
            
            $this->assertTrue($one->hasWeatherDailyStat());
            
            $daily = $one->weatherHourlyStat()->create([]);
            
            $this->assertNotNull($daily);
            
            $this->assertTrue($one->hasWeatherHourlyStat());
        }
        
        public function atestAccessorLatitudeLongitude()
        {
            $one =  new App\City();
            
            $one->name = 'Bla';
            
            $one->open_weather_map_id = 1;
            
            $one->country = 'TR';            
            
            $one->latitude = 39.91986800;
            
            $one->longitude = 32.85427100;
            
            $this->assertTrue($one->save()); 
            
            //var_dump((float) 39.91986800 );
            $this->assertEquals('39.919868', (string) $one->latitude);                          
        }

        
}