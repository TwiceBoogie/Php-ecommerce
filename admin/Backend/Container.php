<?php

class Container
{

    protected static $instance;

    public static function setContainer(\Pimple\Container $container)
    {
        self::$instance = $container;
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}
