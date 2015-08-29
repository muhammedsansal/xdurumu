<?php

/**
 * All helpers will be defined into the file
 * 
 * @author Murat Ödünç <murat.asya@gmail.com>
 */


if (!function_exists('createUniqueKeyFromObj')) {
    
    /**
    * To get hashed keys by using class name of given object
    * 
    * @param Object $object
    * @param string dot nation  
    * @return string   hashed class name
    * @throws Exception
    */
    function createUniqueKeyFromObj($object, $dotNation=null) {

        if (is_null($object) || !is_object($object)) {

            throw new Exception('Cache key is not genereted!, Parameter is invalid! Parameter must be Object');
        }

        $className  = get_class($object);
        
        $mixes      = $className . $dotNation;
        
        return md5($mixes);            
    }

}

if (!function_exists('getProperty')) {    
    
    /**
     * To get property on given object
     * 
     * @param \stdClass $object
     * @param string $property
     * @param mixed $default
     * @return mixed
     */
    function getProperty(\stdClass $object, $property="", $default= null)                
    {            
        return isset($object->{$property}) ? $object->{$property} : $default;
    }
}