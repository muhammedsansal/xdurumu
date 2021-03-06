<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Weather\DailyStat;


class WeatherDailyStatTest extends TestCase
{
        use DatabaseMigrations, DatabaseTransactions;
     
        public function testSimpleCRUD()
        {
            
            $current = factory(App\Weather\DailyStat::class, 2)
                        ->make()
                        ->each(function(\App\Weather\DailyStat $cur){
                            
                            $cur->city()->associate(factory(\App\City::class)->create());
                        });
            
            $this->assertCount(2, $current);
        }
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new DailyStat();                     
        }


        public function testSimpleTwo() 
        {            
            /**
             * Todos:
             *    - Model factoring should rewrite again to using models in relation
             */
            $data =  [
                    'city_id'                       => factory(\App\City::class)->make(),                  
                    'weather_forecast_resource_id'  => factory(\App\WeatherForeCastResource::class)->make()->id,        
                    'enable'                        => (boolean) rand(0, 1),
            ];
            
            $one = $this->createNewWeatherDailyStat($data); 
            
            $this->assertEquals($data['city_id'], $one['city_id']);
        
            $this->assertEquals($data['weather_forecast_resource_id'], $one['weather_forecast_resource_id']);
            $this->assertEquals($data['enable'], $one['enable']);         
        }
        
        public function testWithFakerAttributes() 
        {            
                       
            $one = factory(App\Weather\DailyStat::class)->make();      
        }
        
        public function testRelations() 
        {
            $one = $this->createNewWeatherDailyStat();
            
            $this->assertInstanceOf('App\WeatherForeCastResource', $one->foreCastResource()->getRelated());        
            $this->assertInstanceOf('App\City', $one->city()->getRelated());                       
        }
        
        /**
         * 
         * @return \App\WeatherHourlyStat
         */
        protected function createNewWeatherDailyStat(array $attributes=[])
        {            
            return factory(App\Weather\DailyStat::class)->make($attributes);
        }          
       
        public function atestFirstOrCreateForMain()
        {            
            $current = factory(App\Weather\DailyStat::class, 2)
                        ->make()
                        ->each(function(\App\Weather\DailyStat $cur){
                            
                            $cur->city()->associate(factory(\App\City::class)->create());
                        })->each(function(\App\Weather\DailyStat $cur){
                            
                            $cur->save();
                        });                     
                        
           $first = $current->first();
           
           $main = factory(App\WeatherMain::class)->make();
                      
           $this->assertCount(0, App\WeatherMain::all());
           
           $mainCreated = $first->main()->firstOrCreate($main->toArray());     
           
           $this->assertTrue($mainCreated->save());
                
           $this->assertCount(1, App\WeatherMain::all());
           
           $this->assertEquals($first->id, $mainCreated->weather_hourly_id);
           
           $this->assertEquals($first->id, $first->main->weather_hourly_id);
           
           $this->assertNotNull($first->main);
           
           $this->assertCount(1, App\WeatherMain::all());       
           
           $mainCreated2 = $first->main()->firstOrCreate(array());              
           
           $this->assertTrue($mainCreated2->save($main->toArray()));
           
           $this->assertCount(1, App\WeatherMain::all());
           
        }
        
        
}