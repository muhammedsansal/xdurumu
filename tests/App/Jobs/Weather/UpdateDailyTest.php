<?php

use Mockery as m;
use App\Jobs\Weather\UpdateDaily;

/**
 * //
 * 
 */
class UpdateDailyTest extends \TestCase
{
    
        public function setUp()
        {
            parent::setUp();       
        }
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
        }        
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedRepository()
        {
            return m::mock('App\Contracts\Weather\Repository\IDaily');
        } 
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedApiServiceFactory()
        {
            return m::mock('App\Libs\Weather\ApiServiceFactory');
        } 
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedAccessor()
        {
            return m::mock('App\Contracts\Weather\Accessor');
        }       
        
        public function testSimple()
        {
            $city   = factory(App\City::class)->make();
            
            $current= $this->getMockedRepository();            
            
            $job = new UpdateDaily($city, $current);          
        }   
        
                
        public function testSimpleHandle()
        {
            $app = app();
            
            $accessor = $this->getMockedAccessor();
            
            $apiFactory = $this->getMockedApiServiceFactory();
            
            $apiFactory->shouldReceive('defaultClient')->andReturnSelf();
            
            $apiFactory->shouldReceive('selectCity')->andReturnSelf();
            
            $apiFactory->shouldReceive('daily')->andReturnSelf();
            
            $apiFactory->shouldReceive('sendRequest')->andReturn($accessor);
            
            $app['app.weather.factory'] = $apiFactory;          
            
            $city   = factory(App\City::class)->make();
            
            $city->exists = true;
            
            $current= $this->getMockedRepository();  
            
            $current->exists = true;
            
            $current->shouldReceive('selectCity')->andReturnSelf();
            
            $current->shouldReceive('import')->andReturnSelf();            
            
            $job = new UpdateDaily($city);       
            
            $job->handle($current); 
        }        
}