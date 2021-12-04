<?php

class SplLoader
{
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    
    static function autoload($class){ 
        $class = str_replace('\\', '/', $class); 
        require $class . '.php';
        }
}
