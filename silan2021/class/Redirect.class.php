<?php

/**
 * User: Hansz
 * Date: 7/5/2016
 * Time: 2:22
 */
class Redirect {
    public static function to($location){
        if($location){
            header('Location: '.$location);
            exit();
        }
    }
}