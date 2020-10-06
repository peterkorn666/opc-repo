<?php

/**
 * User: Hansz
 * Date: 7/5/2016
 * Time: 2:11
 */
class Config {
    public static function get($path = null) {
        if($path) {
            $config = (isset($GLOBALS['config']))? $GLOBALS['config']:null;
            $path = explode('/', $path);
            foreach($path as $bit){
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}