<?php

/**
 * Class Container
 */
class Container
{

    protected static $instance;

    /**
     * @param \Pimple\Container $container
     */
    public static function setContainer(\Pimple\Container $container)
    {
        self::$instance = $container;
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}
