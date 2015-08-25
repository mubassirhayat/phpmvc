<?php

use \RequestHandler\RequestHandler;
/**
*
*/
class ControllerFactory
{
    public static function create($controller)
    {
        require_once '../app/controllers/' . $controller . '.php';
        return new $controller;
    }
}
