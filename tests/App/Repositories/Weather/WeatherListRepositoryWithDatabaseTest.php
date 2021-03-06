<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\Weather\ListRepo as Repository;
use App\Libs\Weather\OpenWeatherMap;
//use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class WeatherListRepositoryWithDatabaseTest extends \TestCase
{      
    
    use DatabaseMigrations, DatabaseTransactions;
    
     /**
     * Example oj JSON
     * 
     * Hourly weather data
     *
     * @var type 
     */
    private  $hourly = '{"city":{"id":524901,"name":"Moscow","coord":{"lon":37.615555,"lat":55.75222},"country":"RU","population":0,"sys":{"population":0}},"cod":"200","message":0.0105,"cnt":37,"list":[{"dt":1439370000,"main":{"temp":297.81,"temp_min":296.615,"temp_max":297.81,"pressure":1018.72,"sea_level":1038.29,"grnd_level":1018.72,"humidity":59,"temp_kf":1.19},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":1.71,"deg":136.501},"sys":{"pod":"d"},"dt_txt":"2015-08-12 09:00:00"},{"dt":1439380800,"main":{"temp":298.89,"temp_min":297.992,"temp_max":298.89,"pressure":1017.85,"sea_level":1037.21,"grnd_level":1017.85,"humidity":51,"temp_kf":0.89},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":1.66,"deg":139.001},"sys":{"pod":"d"},"dt_txt":"2015-08-12 12:00:00"},{"dt":1439391600,"main":{"temp":298.36,"temp_min":297.761,"temp_max":298.36,"pressure":1016.47,"sea_level":1035.79,"grnd_level":1016.47,"humidity":46,"temp_kf":0.6},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":1.66,"deg":159.002},"sys":{"pod":"d"},"dt_txt":"2015-08-12 15:00:00"},{"dt":1439402400,"main":{"temp":292.57,"temp_min":292.269,"temp_max":292.57,"pressure":1015.67,"sea_level":1035.26,"grnd_level":1015.67,"humidity":60,"temp_kf":0.3},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":1.66,"deg":122.505},"sys":{"pod":"n"},"dt_txt":"2015-08-12 18:00:00"},{"dt":1439413200,"main":{"temp":289.954,"temp_min":289.954,"temp_max":289.954,"pressure":1014.9,"sea_level":1034.55,"grnd_level":1014.9,"humidity":64,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.9,"deg":132.5},"sys":{"pod":"n"},"dt_txt":"2015-08-12 21:00:00"},{"dt":1439424000,"main":{"temp":289.447,"temp_min":289.447,"temp_max":289.447,"pressure":1013.81,"sea_level":1033.46,"grnd_level":1013.81,"humidity":62,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02n"}],"clouds":{"all":24},"wind":{"speed":3.01,"deg":152.001},"sys":{"pod":"n"},"dt_txt":"2015-08-13 00:00:00"},{"dt":1439434800,"main":{"temp":290.449,"temp_min":290.449,"temp_max":290.449,"pressure":1012.37,"sea_level":1031.87,"grnd_level":1012.37,"humidity":57,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":36},"wind":{"speed":2.97,"deg":177.504},"sys":{"pod":"d"},"dt_txt":"2015-08-13 03:00:00"},{"dt":1439445600,"main":{"temp":295.958,"temp_min":295.958,"temp_max":295.958,"pressure":1010.92,"sea_level":1030.33,"grnd_level":1010.92,"humidity":54,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":20},"wind":{"speed":3.31,"deg":198.002},"sys":{"pod":"d"},"dt_txt":"2015-08-13 06:00:00"},{"dt":1439456400,"main":{"temp":299.785,"temp_min":299.785,"temp_max":299.785,"pressure":1009.31,"sea_level":1028.57,"grnd_level":1009.31,"humidity":48,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":64},"wind":{"speed":3.96,"deg":209.001},"sys":{"pod":"d"},"dt_txt":"2015-08-13 09:00:00"},{"dt":1439467200,"main":{"temp":301.487,"temp_min":301.487,"temp_max":301.487,"pressure":1007.35,"sea_level":1026.51,"grnd_level":1007.35,"humidity":44,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":48},"wind":{"speed":4.01,"deg":210.503},"sys":{"pod":"d"},"dt_txt":"2015-08-13 12:00:00"},{"dt":1439478000,"main":{"temp":298.528,"temp_min":298.528,"temp_max":298.528,"pressure":1006.07,"sea_level":1025.31,"grnd_level":1006.07,"humidity":56,"temp_kf":0},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":{"all":64},"wind":{"speed":3.66,"deg":243.503},"rain":{"3h":0.66},"sys":{"pod":"d"},"dt_txt":"2015-08-13 15:00:00"},{"dt":1439488800,"main":{"temp":293.54,"temp_min":293.54,"temp_max":293.54,"pressure":1006.24,"sea_level":1025.67,"grnd_level":1006.24,"humidity":81,"temp_kf":0},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"clouds":{"all":88},"wind":{"speed":2.52,"deg":287.006},"rain":{"3h":0.64},"sys":{"pod":"n"},"dt_txt":"2015-08-13 18:00:00"},{"dt":1439499600,"main":{"temp":291.899,"temp_min":291.899,"temp_max":291.899,"pressure":1007.26,"sea_level":1026.67,"grnd_level":1007.26,"humidity":89,"temp_kf":0},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"clouds":{"all":80},"wind":{"speed":4.31,"deg":337.5},"rain":{"3h":0.24},"sys":{"pod":"n"},"dt_txt":"2015-08-13 21:00:00"},{"dt":1439510400,"main":{"temp":289.958,"temp_min":289.958,"temp_max":289.958,"pressure":1008.26,"sea_level":1027.85,"grnd_level":1008.26,"humidity":88,"temp_kf":0},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"clouds":{"all":68},"wind":{"speed":3.91,"deg":338.503},"rain":{"3h":0.15},"sys":{"pod":"n"},"dt_txt":"2015-08-14 00:00:00"},{"dt":1439521200,"main":{"temp":288.554,"temp_min":288.554,"temp_max":288.554,"pressure":1009.52,"sea_level":1029.2,"grnd_level":1009.52,"humidity":85,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":12},"wind":{"speed":3.76,"deg":349.5},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 03:00:00"},{"dt":1439532000,"main":{"temp":290.175,"temp_min":290.175,"temp_max":290.175,"pressure":1010.72,"sea_level":1030.21,"grnd_level":1010.72,"humidity":70,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":3.55,"deg":347.503},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 06:00:00"},{"dt":1439542800,"main":{"temp":292.427,"temp_min":292.427,"temp_max":292.427,"pressure":1010.75,"sea_level":1030.29,"grnd_level":1010.75,"humidity":63,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":3.62,"deg":332.505},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 09:00:00"},{"dt":1439553600,"main":{"temp":293.734,"temp_min":293.734,"temp_max":293.734,"pressure":1010.59,"sea_level":1030.08,"grnd_level":1010.59,"humidity":54,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":4.01,"deg":320.002},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 12:00:00"},{"dt":1439564400,"main":{"temp":293.126,"temp_min":293.126,"temp_max":293.126,"pressure":1010.21,"sea_level":1029.64,"grnd_level":1010.21,"humidity":48,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":4.05,"deg":316.507},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 15:00:00"},{"dt":1439575200,"main":{"temp":289.74,"temp_min":289.74,"temp_max":289.74,"pressure":1010.31,"sea_level":1029.9,"grnd_level":1010.31,"humidity":49,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":3.01,"deg":322.504},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-14 18:00:00"},{"dt":1439586000,"main":{"temp":286.789,"temp_min":286.789,"temp_max":286.789,"pressure":1010.56,"sea_level":1030.05,"grnd_level":1010.56,"humidity":61,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.42,"deg":319.5},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-14 21:00:00"},{"dt":1439596800,"main":{"temp":284.731,"temp_min":284.731,"temp_max":284.731,"pressure":1010.11,"sea_level":1029.87,"grnd_level":1010.11,"humidity":73,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.37,"deg":296.508},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-15 00:00:00"},{"dt":1439607600,"main":{"temp":284.584,"temp_min":284.584,"temp_max":284.584,"pressure":1009.68,"sea_level":1029.4,"grnd_level":1009.68,"humidity":75,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"02d"}],"clouds":{"all":8},"wind":{"speed":2.26,"deg":296.508},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 03:00:00"},{"dt":1439618400,"main":{"temp":291.224,"temp_min":291.224,"temp_max":291.224,"pressure":1009.45,"sea_level":1028.99,"grnd_level":1009.45,"humidity":60,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":2.47,"deg":307.508},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 06:00:00"},{"dt":1439629200,"main":{"temp":293.645,"temp_min":293.645,"temp_max":293.645,"pressure":1008.76,"sea_level":1028.17,"grnd_level":1008.76,"humidity":56,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":12},"wind":{"speed":4.01,"deg":311.009},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 09:00:00"},{"dt":1439640000,"main":{"temp":294.964,"temp_min":294.964,"temp_max":294.964,"pressure":1007.83,"sea_level":1027.18,"grnd_level":1007.83,"humidity":50,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":20},"wind":{"speed":4.32,"deg":311},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 12:00:00"},{"dt":1439650800,"main":{"temp":294.352,"temp_min":294.352,"temp_max":294.352,"pressure":1006.95,"sea_level":1026.49,"grnd_level":1006.95,"humidity":46,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":36},"wind":{"speed":4.5,"deg":321.001},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 15:00:00"},{"dt":1439661600,"main":{"temp":292.571,"temp_min":292.571,"temp_max":292.571,"pressure":1007.35,"sea_level":1026.83,"grnd_level":1007.35,"humidity":48,"temp_kf":0},"weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04n"}],"clouds":{"all":92},"wind":{"speed":3.92,"deg":333.503},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-15 18:00:00"},{"dt":1439672400,"main":{"temp":291.261,"temp_min":291.261,"temp_max":291.261,"pressure":1007.67,"sea_level":1027.23,"grnd_level":1007.67,"humidity":52,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":76},"wind":{"speed":2.96,"deg":342.5},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-15 21:00:00"},{"dt":1439683200,"main":{"temp":289.615,"temp_min":289.615,"temp_max":289.615,"pressure":1008.04,"sea_level":1027.76,"grnd_level":1008.04,"humidity":54,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":68},"wind":{"speed":2.42,"deg":341.003},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-16 00:00:00"},{"dt":1439694000,"main":{"temp":286.322,"temp_min":286.322,"temp_max":286.322,"pressure":1008.53,"sea_level":1028.33,"grnd_level":1008.53,"humidity":69,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":1.87,"deg":337.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 03:00:00"},{"dt":1439704800,"main":{"temp":290.622,"temp_min":290.622,"temp_max":290.622,"pressure":1009.14,"sea_level":1028.66,"grnd_level":1009.14,"humidity":58,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":2.31,"deg":1.00183},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 06:00:00"},{"dt":1439715600,"main":{"temp":292.009,"temp_min":292.009,"temp_max":292.009,"pressure":1009.35,"sea_level":1028.81,"grnd_level":1009.35,"humidity":53,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":56},"wind":{"speed":3.67,"deg":338.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 09:00:00"},{"dt":1439726400,"main":{"temp":293.024,"temp_min":293.024,"temp_max":293.024,"pressure":1009.44,"sea_level":1028.78,"grnd_level":1009.44,"humidity":47,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":4.1,"deg":335.002},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 12:00:00"},{"dt":1439737200,"main":{"temp":292.269,"temp_min":292.269,"temp_max":292.269,"pressure":1009.53,"sea_level":1028.98,"grnd_level":1009.53,"humidity":41,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":4.37,"deg":347.003},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 15:00:00"},{"dt":1439748000,"main":{"temp":288.765,"temp_min":288.765,"temp_max":288.765,"pressure":1010.66,"sea_level":1030.16,"grnd_level":1010.66,"humidity":45,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":3.92,"deg":3.50281},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-16 18:00:00"},{"dt":1439758800,"main":{"temp":285.752,"temp_min":285.752,"temp_max":285.752,"pressure":1011.37,"sea_level":1031.23,"grnd_level":1011.37,"humidity":63,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.71,"deg":6.00958},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-16 21:00:00"}]}';
    
    
       
    /**
     * Example of json response
     *
     * Daily
     * 
     * @var string JSON 
     */
    private $daily ='{"city":{"id":1260206,"name":"Pasighat","coord":{"lon":95.333328,"lat":28.066669},"country":"IN","population":0},"cod":"200","message":0.0208,"cnt":16,"list":[{"dt":1439874000,"temp":{"day":293.51,"min":293.34,"max":293.51,"night":293.34,"eve":293.51,"morn":293.51},"pressure":902.33,"humidity":99,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.66,"deg":51,"clouds":100,"rain":25.39},{"dt":1439960400,"temp":{"day":293.72,"min":292.54,"max":293.72,"night":292.54,"eve":293.56,"morn":293.27},"pressure":903.9,"humidity":100,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.86,"deg":120,"clouds":92,"rain":43.61},{"dt":1440046800,"temp":{"day":293.87,"min":292.18,"max":294.32,"night":292.96,"eve":294.32,"morn":292.18},"pressure":905.47,"humidity":96,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.87,"deg":51,"clouds":92,"rain":36.55},{"dt":1440133200,"temp":{"day":294.08,"min":292.19,"max":294.08,"night":292.34,"eve":294.07,"morn":292.19},"pressure":919.79,"humidity":0,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.96,"deg":79,"clouds":79,"rain":30.09},{"dt":1440219600,"temp":{"day":296.26,"min":292.1,"max":296.26,"night":292.94,"eve":295.92,"morn":292.1},"pressure":918.74,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.88,"deg":41,"clouds":48,"rain":7.2},{"dt":1440306000,"temp":{"day":300.29,"min":292.82,"max":300.29,"night":294.06,"eve":297.31,"morn":292.82},"pressure":917.51,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":0.99,"deg":128,"clouds":4,"rain":2.65},{"dt":1440392400,"temp":{"day":300.28,"min":293.4,"max":300.28,"night":294.77,"eve":297.94,"morn":293.4},"pressure":917.77,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":0.87,"deg":103,"clouds":7,"rain":2.07},{"dt":1440478800,"temp":{"day":300.39,"min":294.16,"max":300.39,"night":294.43,"eve":297.64,"morn":294.16},"pressure":917.31,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.83,"deg":120,"clouds":6,"rain":7.75},{"dt":1440565200,"temp":{"day":299.04,"min":294.04,"max":299.04,"night":294.27,"eve":296.77,"morn":294.04},"pressure":916.26,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.92,"deg":242,"clouds":25,"rain":10},{"dt":1440651600,"temp":{"day":299.53,"min":294.04,"max":299.53,"night":294.54,"eve":297.43,"morn":294.04},"pressure":916.67,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.88,"deg":135,"clouds":37,"rain":4.45},{"dt":1440738000,"temp":{"day":299.99,"min":294.1,"max":299.99,"night":294.79,"eve":297.83,"morn":294.1},"pressure":917.7,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":1.02,"deg":127,"clouds":46,"rain":4.32},{"dt":1440824400,"temp":{"day":299.27,"min":294.41,"max":299.27,"night":294.7,"eve":296.92,"morn":294.41},"pressure":919.61,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":1.04,"deg":191,"clouds":66,"rain":5.22},{"dt":1440910800,"temp":{"day":298.36,"min":294.55,"max":298.36,"night":294.73,"eve":297.06,"morn":294.55},"pressure":920.91,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.91,"deg":186,"clouds":74,"rain":9.05},{"dt":1440997200,"temp":{"day":300.91,"min":294.27,"max":300.91,"night":295.01,"eve":297.71,"morn":294.27},"pressure":922.51,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.85,"deg":177,"clouds":16,"rain":6.57},{"dt":1441083600,"temp":{"day":300.14,"min":294.38,"max":300.14,"night":294.67,"eve":297.14,"morn":294.38},"pressure":923.81,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.99,"deg":219,"clouds":18,"rain":10.13},{"dt":1441170000,"temp":{"day":294.65,"min":294.65,"max":294.65,"night":294.65,"eve":294.65,"morn":294.65},"pressure":925.18,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.7,"deg":330,"clouds":67,"rain":5.5}]}';
    
   
    
    
        public function setUp()
        {
            parent::setUp();        
           
        }
        
        /**
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        private function getHourlyData()
        {
            return (new OpenWeatherMap($this->hourly))->hourly();            
        }     
        
        /**
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        private function getDailyData()
        {
            return (new OpenWeatherMap($this->daily))->daily();            
        }  
        
        /**
         * 
         * 
         * @return \App\City
         */
        private function createCity()
        {       
            return factory(\App\City::class)->create();            
        }
        
        /**
         * 
         * @return \App\WeatherForeCastResource
         */
        private function createWeatherForeCastResource()
        {
            return factory(\App\WeatherForeCastResource::class)->create();            
        }
        
        
        private function createWeatherHourlyStat()
        {
            $city       = $this->createCity();
            
            $resource   = $this->createWeatherForeCastResource();
            
            $hourly     = factory(\App\WeatherHourlyStat::class)->make();                     
            
            $hourly->city_id = $city->id;
            
            $hourly->weather_forecast_resource_id = $resource->id;
            
            if ( $hourly->save()) {
                
                return $hourly;
            }
            
            throw new \Exception('WeatherHourlyStat Model is not created!');
            
        }
        
        private function createWeatherDailyStat()
        {
            $city       = $this->createCity();
            
            $resource   = $this->createWeatherForeCastResource();
            
            $hourly     = factory(App\Weather\DailyStat::class)->make();                     
            
            $hourly->city_id = $city->id;
            
            $hourly->weather_forecast_resource_id = $resource->id;
            
            if ( $hourly->save()) {
                
                return $hourly;
            }
            
            throw new \Exception('WeatherDailyStat Model is not created!');
            
        }

        /**
         * To get WeatherList model
         * 
         * @return \App\WeatherList
         */
        private function getWeatherListModel()
        {
            return new App\WeatherList();            
        }
        /**
         * Cache Instance
         *  
         * @return 
         */
        private function getCache()
        {
            return \app('cache')->driver();            
        }
        
        /**
         * Config Instance
         *  
         * @return \Mockery\MockInterface
         */
        private function getConfig()
        {
            return \app('config');
        }
        
        
        /**
         * 
         * @return \App\Contracts\Weather\Repository\Condition
         */
        private function getConditionRepo()
        {
            return app('App\Contracts\Weather\Repository\Condition');            
        }        
    

        public function testSimple()
        {           
            $condition  = $this->getConditionRepo();
            
            //$resource   = $this->getWeatherForeCastResourceMock();
            
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();      
            
            $one = new Repository($cache, $config, $list, $condition);            
            
        }   
        
        public function testCreateListByHourlyStat()
        {              
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();  
            
            $condition  = $this->getConditionRepo();
            
            $one = new Repository($cache, $config, $list, $condition);   
            
            $hourlyStat = $this->createWeatherHourlyStat();
            
            $hourlyData = $this->getHourlyData();            
            
            $creates = $one->createListsByHourlyStat($hourlyStat, $hourlyData->getWeatherData());         
            
            $numberOflistInJson = count($hourlyData->getWeatherData()->getAttribute('list'));           
            
            $this->assertCount($numberOflistInJson, $creates);
            
            $this->assertCount($numberOflistInJson, App\WeatherList::all());
            
            $this->assertCount($numberOflistInJson, App\WeatherMain::all());
            
            $this->assertCount($numberOflistInJson, App\WeatherWind::all());
            
            $this->assertCount($numberOflistInJson, App\WeatherCloud::all());
            
            $numberOfRain = $this->countNotNullElement('rain');
            
            $this->assertCount($numberOfRain, App\WeatherRain::all());
            
            $this->assertCount(0, App\WeatherSnow::all());
            
            foreach (App\WeatherList::all() as $one)
            {
                $this->assertNotNull($one->dt);
                
                $this->assertTrue(is_numeric($one->dt));
            }
            
            foreach (App\WeatherList::all() as $one)
            {
                $this->assertNotNull($one->date_time);                
              
                $this->assertTrue(is_string($one->date_time));
            }        
        }   
        
        
        public function testExistsConditionAgainCreatedIssue()
        {              
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();      
            
            $condition  = $this->getConditionRepo();
            
            $one = new Repository($cache, $config, $list, $condition);   
            
            $hourlyStat = $this->createWeatherHourlyStat();
            
            $hourlyData = $this->getHourlyData();            
            
            $creates = $one->createListsByHourlyStat($hourlyStat, $hourlyData->getWeatherData());         
            
            $numberOflistInJson = count($hourlyData->getWeatherData()->getAttribute('list'));      
            
            $numberOfConditions = App\WeatherCondition::all()->count();
            
            $this->assertTrue($numberOfConditions > 1);
            
            $creates1 = $one->createListsByHourlyStat($hourlyStat, $hourlyData->getWeatherData());              
            
            $this->assertEquals($numberOfConditions, App\WeatherCondition::all()->count());     
            
        }  
        
        
        public function testGetAllHourlyStat()
        {              
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();      
            
            $condition  = $this->getConditionRepo();
            
            $one = new Repository($cache, $config, $list, $condition);   
            
            $hourlyStat = $this->createWeatherHourlyStat();
            
            $hourlyData = $this->getHourlyData();            
            
            $creates = [];
            
            for ($i=0 ; $i < 10; $i++ ) {
                
                $creates[] = $one->createListsByHourlyStat($hourlyStat, $hourlyData->getWeatherData());             
            }
            
            $this->assertCount(10, $creates);    
 
            $this->assertCount(10*37, $one->getAllHourlyList());        
        } 
        
        
        public function testGetAllDailyStat()
        {              
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();      
            
            $condition  = $this->getConditionRepo();
            
            $one = new Repository($cache, $config, $list, $condition);   
            
            $dailyStat = $this->createWeatherDailyStat();
            
            $data = $this->getDailyData();     
            
            $numberOflistInJson = count($data->getWeatherData()->getAttribute('list'));      
            
            $creates = [];
            
            for ($i=0 ; $i < 10; $i++ ) {
                
                $creates[] = $one->createListsByDailyStat($dailyStat, $data->getWeatherData());             
            }
            
            $this->assertCount(10, $creates);    
 
            $this->assertCount(10* $numberOflistInJson, $one->getAllDailyList());        
        } 
        
        /**
         * To count not empty or not null elements in json example data
         * 
         * @param string $name
         * @return int
         */
        private function countNotNullElement($name)
        {
            $rawData = json_decode($this->hourly, true);            
            
            $no = 0; 
            
            foreach ($rawData['list'] as $one) {
                
                $elem = isset($one[$name]) ? $one[$name] : null;                
                
                if ( is_null($elem) || empty($elem)) {
                    
                    continue;                    
                }
                
                $no++;                
            }
            
            return $no;       
        }
        
        
        public function testGetLastListsByMode()
        {              
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();      
            
            $condition  = $this->getConditionRepo();
            
            $repo = new Repository($cache, $config, $list, $condition);   
            
            $hourlyStat = $this->createWeatherHourlyStat();
            
            $hourlyData = $this->getHourlyData();            
            
            $creates = [];
            
            for ($i=0 ; $i < 2; $i++ ) {
                
                $creates[] = $repo->createListsByHourlyStat($hourlyStat, $hourlyData->getWeatherData());             
            }
            
            $this->assertCount(2, $creates);                 
         
            $hourlyLists = $repo->getLastListsByModel($hourlyStat);   
            
            $numberOflistInJson = count($hourlyData->getWeatherData()->getAttribute('list'));      
            
            $this->assertCount($numberOflistInJson, $hourlyLists);
            
            $this->assertNotEquals(1, $hourlyLists->first()->id);
            
            $this->assertNotEquals(74, $hourlyLists->last()->id);            
        } 
        
        public function testGetLastListsByModePassedDailyStat()
        {              
            $list       = $this->getWeatherListModel();
            
            $cache      = $this->getCache();
            
            $config     = $this->getConfig();      
            
            $condition  = $this->getConditionRepo();
            
            $repo = new Repository($cache, $config, $list, $condition);   
            
            $dailyStat = $this->createWeatherDailyStat();
            
            $data = $this->getDailyData();     
            
            //$numberOflistInJson = count($data->getWeatherData()->getAttribute('list'));      
            
            $creates = [];          
            
            for ($i=0 ; $i < 10; $i++ ) {
                
                $creates[] = $repo->createListsByDailyStat($dailyStat, $data->getWeatherData());             
            }         
             
            $dailyLists = $repo->getLastListsByModel($dailyStat);
            
            $this->assertCount(16, $dailyLists);                  
               
        }      
}