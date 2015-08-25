<?php

use \RequestHandler\RequestHandler;
/**
*
*/
class ControllerFactory
{
    public static function create($controller)
    {
        if(file_exists('../app/controllers/' . $controller . '.php')){
            require_once '../app/controllers/' . $controller . '.php';
            return new $controller;
        }

    }
}
