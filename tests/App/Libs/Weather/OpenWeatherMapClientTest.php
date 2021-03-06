<?php


use App\Libs\Weather\OpenWeatherMap as Accessor;
use App\Libs\Weather\OpenWeatherMapClient as Client;
use Mockery as m;
/**
 * Test file for App\Libs\Weather\OpenWeatherMap class
 * 
 */
class OpenWeatherMapClientTest extends \TestCase
{
    
    /**
     * Current
     *
     * @var string
     */
    private $current= '{
                    "coord":{"lon":139,"lat":35},
                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
                    "main":{
                                    "temp":289.5,
                                    "humidity":89,
                                    "pressure":1013,
                                    "temp_min":287.04,
                                    "temp_max":292.04
                                    },
                    "wind":{"speed":7.31,"deg":187.002}, 
                    "rain":{"3h":0},
                    "snow":{"3h":1},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
    
    /**
     * Hourly
     *
     * @var string 
     */
    private $hourly = '{"city":{"id":745042,"name":"İstanbul","country":"TR","coord":{"lon":28.983311,"lat":41.03508}},"time":1411447617,"data":[{"dt":1411441200,"main":{"temp":294.08,"temp_min":294.08,"temp_max":295.877,"pressure":1016.53,"sea_level":1018.28,"grnd_level":1016.53,"humidity":98,"temp_kf":-1.8},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":68},"wind":{"speed":6.81,"deg":279.508},"sys":{"pod":"n"},"dt_txt":"2014-09-23 03:00:00"},{"dt":1411452000,"main":{"temp":292.94,"temp_min":292.94,"temp_max":294.644,"pressure":1017.49,"sea_level":1019.43,"grnd_level":1017.49,"humidity":100,"temp_kf":-1.71},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":56},"wind":{"speed":5.21,"deg":317.002},"sys":{"pod":"d"},"dt_txt":"2014-09-23 06:00:00"},{"dt":1411462800,"main":{"temp":292.7,"temp_min":292.7,"temp_max":294.321,"pressure":1017.35,"sea_level":1019.2,"grnd_level":1017.35,"humidity":100,"temp_kf":-1.62},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":44},"wind":{"speed":2.46,"deg":329.008},"sys":{"pod":"d"},"dt_txt":"2014-09-23 09:00:00"},{"dt":1411473600,"main":{"temp":292.69,"temp_min":292.69,"temp_max":294.221,"pressure":1015.17,"sea_level":1017.2,"grnd_level":1015.17,"humidity":100,"temp_kf":-1.53},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":76},"wind":{"speed":3.91,"deg":342.001},"sys":{"pod":"d"},"dt_txt":"2014-09-23 12:00:00"},{"dt":1411484400,"main":{"temp":289.34,"temp_min":289.34,"temp_max":290.78,"pressure":1018.2,"sea_level":1020,"grnd_level":1018.2,"humidity":100,"temp_kf":-1.44},"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"clouds":{"all":92},"wind":{"speed":16.23,"deg":314.501},"rain":{"3h":5},"sys":{"pod":"d"},"dt_txt":"2014-09-23 15:00:00"},{"dt":1411495200,"main":{"temp":289.18,"temp_min":289.18,"temp_max":290.525,"pressure":1022.69,"sea_level":1024.82,"grnd_level":1022.69,"humidity":100,"temp_kf":-1.35},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"clouds":{"all":56},"wind":{"speed":13.16,"deg":300.005},"rain":{"3h":0.5},"sys":{"pod":"n"},"dt_txt":"2014-09-23 18:00:00"},{"dt":1411506000,"main":{"temp":289.71,"temp_min":289.71,"temp_max":290.97,"pressure":1025.27,"sea_level":1027.27,"grnd_level":1025.27,"humidity":100,"temp_kf":-1.26},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":64},"wind":{"speed":10.43,"deg":292.5},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-23 21:00:00"},{"dt":1411516800,"main":{"temp":289.58,"temp_min":289.58,"temp_max":290.748,"pressure":1026.77,"sea_level":1028.73,"grnd_level":1026.77,"humidity":100,"temp_kf":-1.17},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":80},"wind":{"speed":9.05,"deg":291.501},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-24 00:00:00"},{"dt":1411527600,"main":{"temp":289.43,"temp_min":289.43,"temp_max":290.512,"pressure":1028.14,"sea_level":1030.08,"grnd_level":1028.14,"humidity":100,"temp_kf":-1.08},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":68},"wind":{"speed":8.32,"deg":284.501},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-24 03:00:00"},{"dt":1411538400,"main":{"temp":289.24,"temp_min":289.24,"temp_max":290.225,"pressure":1029.99,"sea_level":1031.87,"grnd_level":1029.99,"humidity":100,"temp_kf":-0.99},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":36},"wind":{"speed":7.36,"deg":274.501},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-24 06:00:00"},{"dt":1411549200,"main":{"temp":289.47,"temp_min":289.47,"temp_max":290.364,"pressure":1031.06,"sea_level":1032.92,"grnd_level":1031.06,"humidity":100,"temp_kf":-0.9},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":44},"wind":{"speed":6.42,"deg":269.5},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-24 09:00:00"},{"dt":1411560000,"main":{"temp":290.37,"temp_min":290.37,"temp_max":291.174,"pressure":1031.06,"sea_level":1032.94,"grnd_level":1031.06,"humidity":100,"temp_kf":-0.81},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":32},"wind":{"speed":5.22,"deg":273.502},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-24 12:00:00"},{"dt":1411570800,"main":{"temp":290.92,"temp_min":290.92,"temp_max":291.636,"pressure":1031,"sea_level":1032.82,"grnd_level":1031,"humidity":100,"temp_kf":-0.72},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":12},"wind":{"speed":3.87,"deg":281.002},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-24 15:00:00"},{"dt":1411581600,"main":{"temp":290.87,"temp_min":290.87,"temp_max":291.499,"pressure":1031.55,"sea_level":1033.42,"grnd_level":1031.55,"humidity":100,"temp_kf":-0.63},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03n"}],"clouds":{"all":44},"wind":{"speed":3.11,"deg":286.002},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-24 18:00:00"},{"dt":1411592400,"main":{"temp":290.96,"temp_min":290.96,"temp_max":291.499,"pressure":1031.71,"sea_level":1033.49,"grnd_level":1031.71,"humidity":100,"temp_kf":-0.54},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":68},"wind":{"speed":2.87,"deg":276.009},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-24 21:00:00"},{"dt":1411603200,"main":{"temp":291.01,"temp_min":291.01,"temp_max":291.456,"pressure":1031.15,"sea_level":1033.12,"grnd_level":1031.15,"humidity":100,"temp_kf":-0.45},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":56},"wind":{"speed":2.61,"deg":259.008},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-25 00:00:00"},{"dt":1411614000,"main":{"temp":290.99,"temp_min":290.99,"temp_max":291.353,"pressure":1030.74,"sea_level":1032.69,"grnd_level":1030.74,"humidity":100,"temp_kf":-0.36},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03n"}],"clouds":{"all":32},"wind":{"speed":2.22,"deg":245.001},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-25 03:00:00"},{"dt":1411624800,"main":{"temp":291.4,"temp_min":291.4,"temp_max":291.674,"pressure":1030.32,"sea_level":1032.32,"grnd_level":1030.32,"humidity":100,"temp_kf":-0.27},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":2.05,"deg":192.501},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-25 06:00:00"},{"dt":1411635600,"main":{"temp":291.97,"temp_min":291.97,"temp_max":292.154,"pressure":1030.03,"sea_level":1031.91,"grnd_level":1030.03,"humidity":100,"temp_kf":-0.18},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":1.76,"deg":172.511},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-25 09:00:00"},{"dt":1411646400,"main":{"temp":292.68,"temp_min":292.68,"temp_max":292.768,"pressure":1028.59,"sea_level":1030.45,"grnd_level":1028.59,"humidity":100,"temp_kf":-0.09},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":1.71,"deg":67.5},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-25 12:00:00"},{"dt":1411657200,"main":{"temp":293.022,"temp_min":293.022,"temp_max":293.022,"pressure":1027.64,"sea_level":1029.47,"grnd_level":1027.64,"humidity":100},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":3.31,"deg":82.5063},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-25 15:00:00"},{"dt":1411668000,"main":{"temp":292.844,"temp_min":292.844,"temp_max":292.844,"pressure":1027.42,"sea_level":1029.43,"grnd_level":1027.42,"humidity":100},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":4.16,"deg":98.5059},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-25 18:00:00"},{"dt":1411678800,"main":{"temp":292.849,"temp_min":292.849,"temp_max":292.849,"pressure":1026.68,"sea_level":1028.58,"grnd_level":1026.68,"humidity":100},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":3.82,"deg":113.501},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-25 21:00:00"},{"dt":1411689600,"main":{"temp":292.551,"temp_min":292.551,"temp_max":292.551,"pressure":1025.43,"sea_level":1027.42,"grnd_level":1025.43,"humidity":100},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02n"}],"clouds":{"all":20},"wind":{"speed":3.15,"deg":141.505},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-26 00:00:00"},{"dt":1411700400,"main":{"temp":292.253,"temp_min":292.253,"temp_max":292.253,"pressure":1024.6,"sea_level":1026.53,"grnd_level":1024.6,"humidity":100},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02n"}],"clouds":{"all":12},"wind":{"speed":2.72,"deg":164.001},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-26 03:00:00"},{"dt":1411711200,"main":{"temp":292.675,"temp_min":292.675,"temp_max":292.675,"pressure":1024.33,"sea_level":1026.15,"grnd_level":1024.33,"humidity":100},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":48},"wind":{"speed":2.11,"deg":165.001},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-26 06:00:00"},{"dt":1411722000,"main":{"temp":293.312,"temp_min":293.312,"temp_max":293.312,"pressure":1024.71,"sea_level":1026.5,"grnd_level":1024.71,"humidity":100},"weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],"clouds":{"all":92},"wind":{"speed":1.11,"deg":220.001},"rain":{"3h":0},"sys":{"pod":"d"},"dt_txt":"2014-09-26 09:00:00"},{"dt":1411732800,"main":{"temp":289.881,"temp_min":289.881,"temp_max":289.881,"pressure":1025.01,"sea_level":1026.79,"grnd_level":1025.01,"humidity":100},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":{"all":92},"wind":{"speed":2.66,"deg":228.002},"rain":{"3h":1.5},"sys":{"pod":"d"},"dt_txt":"2014-09-26 12:00:00"},{"dt":1411743600,"main":{"temp":289.382,"temp_min":289.382,"temp_max":289.382,"pressure":1023.88,"sea_level":1025.81,"grnd_level":1023.88,"humidity":100},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":{"all":92},"wind":{"speed":0.51,"deg":97.5049},"rain":{"3h":1},"sys":{"pod":"d"},"dt_txt":"2014-09-26 15:00:00"},{"dt":1411754400,"main":{"temp":290.007,"temp_min":290.007,"temp_max":290.007,"pressure":1023.29,"sea_level":1025.28,"grnd_level":1023.29,"humidity":100},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":76},"wind":{"speed":2.32,"deg":36.5065},"rain":{"3h":0},"sys":{"pod":"n"},"dt_txt":"2014-09-26 18:00:00"},{"dt":1411765200,"main":{"temp":289.414,"temp_min":289.414,"temp_max":289.414,"pressure":1022.92,"sea_level":1024.79,"grnd_level":1022.92,"humidity":100},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"clouds":{"all":92},"wind":{"speed":2.56,"deg":16.5014},"rain":{"3h":2},"sys":{"pod":"n"},"dt_txt":"2014-09-26 21:00:00"},{"dt":1411776000,"main":{"temp":289.896,"temp_min":289.896,"temp_max":289.896,"pressure":1022.28,"sea_level":1024.23,"grnd_level":1022.28,"humidity":100},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"clouds":{"all":92},"wind":{"speed":3.8,"deg":18.0009},"rain":{"3h":1},"sys":{"pod":"n"},"dt_txt":"2014-09-27 00:00:00"}]}';
    
    /**
     * Hourly
     *
     * @var string 
     */
    private $daily = '{"city":{"id":745042,"name":"İstanbul","country":"TR","coord":{"lon":28.983311,"lat":41.03508}},"time":1394865585,"data":[{"dt":1394877600,"temp":{"day":280.64,"min":279.24,"max":282.72,"night":281.36,"eve":282.72,"morn":279.24},"pressure":1029.91,"humidity":93,"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"speed":2.06,"deg":195,"clouds":0},{"dt":1394964000,"temp":{"day":281.57,"min":279.9,"max":281.7,"night":279.95,"eve":279.9,"morn":281.42},"pressure":1021.59,"humidity":92,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":5.96,"deg":280,"clouds":92,"rain":2},{"dt":1395050400,"temp":{"day":281.16,"min":280.87,"max":281.67,"night":281.67,"eve":281.07,"morn":280.97},"pressure":1026.83,"humidity":100,"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"speed":6.13,"deg":4,"clouds":64},{"dt":1395136800,"temp":{"day":284,"min":282.08,"max":285.01,"night":283.85,"eve":285.01,"morn":282.08},"pressure":1032.74,"humidity":85,"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"speed":6.86,"deg":217,"clouds":32},{"dt":1395223200,"temp":{"day":285.58,"min":283.18,"max":286.4,"night":284.3,"eve":286.11,"morn":283.18},"pressure":1032.04,"humidity":77,"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"speed":7.25,"deg":222,"clouds":0},{"dt":1395309600,"temp":{"day":288.39,"min":283.54,"max":288.39,"night":284.41,"eve":285.79,"morn":283.54},"pressure":1018.9,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"speed":5.79,"deg":220,"clouds":0},{"dt":1395396000,"temp":{"day":287.18,"min":285.21,"max":287.18,"night":286.71,"eve":286.16,"morn":285.21},"pressure":1007.12,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":10.78,"deg":220,"clouds":91,"rain":0.47},{"dt":1395482400,"temp":{"day":289.41,"min":283.84,"max":289.41,"night":283.84,"eve":285.77,"morn":285.76},"pressure":1011.84,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":6.22,"deg":251,"clouds":0,"rain":0.23},{"dt":1395568800,"temp":{"day":291.45,"min":284.56,"max":291.45,"night":286.63,"eve":288.52,"morn":284.56},"pressure":1011.63,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":6.62,"deg":200,"clouds":8,"rain":0.69},{"dt":1395655200,"temp":{"day":288.09,"min":286.03,"max":288.09,"night":286.43,"eve":287.35,"morn":286.03},"pressure":1010.89,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":6.16,"deg":213,"clouds":96,"rain":5.15},{"dt":1395741600,"temp":{"day":279.43,"min":279.01,"max":280.61,"night":279.01,"eve":279.01,"morn":280.61},"pressure":1018.51,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"speed":4.71,"deg":344,"clouds":100,"rain":6.85},{"dt":1395828000,"temp":{"day":283.42,"min":279.72,"max":283.42,"night":280.47,"eve":281.69,"morn":279.72},"pressure":1018.17,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"speed":3.61,"deg":211,"clouds":1},{"dt":1395914400,"temp":{"day":284.95,"min":281.22,"max":284.95,"night":281.22,"eve":282.4,"morn":281.42},"pressure":1011.27,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":4.43,"deg":25,"clouds":66,"rain":1.05},{"dt":1396000800,"temp":{"day":284.96,"min":281.99,"max":284.96,"night":282.5,"eve":283.21,"morn":281.99},"pressure":1018.21,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"speed":3.53,"deg":270,"clouds":0,"rain":0.32},{"dt":1396087200,"temp":{"day":287.85,"min":283.11,"max":287.85,"night":283.11,"eve":284.81,"morn":283.39},"pressure":1020.57,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"speed":1.4,"deg":233,"clouds":30},{"dt":1396173600,"temp":{"day":283.11,"min":283.11,"max":283.11,"night":283.11,"eve":283.11,"morn":283.11},"pressure":1019.39,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01ddd"}],"speed":1.72,"deg":257,"clouds":48}]}';
    
    
    
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedResourceModel()
        {
            return m::mock('App\WeatherForeCastResource');
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
        private function getMockedCityModel()
        {
            return m::mock('App\City');
        }
        public function testSimple()
        {
            $source = $this->getMockedResourceModel();
            
            $client = new Client(new Accessor(), $source);        
        }
        
        public function testSendRequest()
        {
            $source = $this->getMockedResourceModel();
            
            $source->shouldReceive('increaseNumberOfApiCall')->andReturn(1);
            
            $source->shouldReceive('getAttribute')->andReturn('http://api.openweathermap.org/data/2.5/');
            
            $city   = $this->getMockedCityModel();
            
            $city->exists = true;
            
            $apiServisFac = $this->getMockedApiServiceFactory();
            
            $app = app();            
            
            $app['app.weather.factory']  = $apiServisFac;
             
            $city->shouldReceive('getAttribute')->andReturn(2172797);
            $client = new Client(new Accessor(), $source); 
            
            $this->expectsEvents(App\Events\Weather\ApiCalled::class);
            
            $weatherCurrent = $client->selectCity($city)->current()->sendRequest();      
            
            $this->assertInstanceOf('App\Libs\Weather\OpenWeatherMap', $weatherCurrent);
            
            $this->assertInstanceOf('App\Contracts\Weather\Accessor', $weatherCurrent);
            
            $this->assertTrue($weatherCurrent->isCurrent());
            
            $this->assertTrue($weatherCurrent->getWeatherData()->isFilledRequiredElements());
        }
        
        public function testAddQuery()
        {
            $source = $this->getMockedResourceModel();
             
            $client = new Client(new Accessor(), $source);     
            
            $client->addQuery('foo' , 'bar');       
        }
   
        
      
}