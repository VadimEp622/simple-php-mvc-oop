<?php

namespace Core;

// INFO: a static method is one that can be called, without having to first instantiate the object.

class App
{
    protected static $container;


    public static function setContainer($container)
    {
        static::$container = $container;
    }

    public static function container()
    {
        return static::$container;
    }

    public static function bind($key, $resolver)
    {
        static::container()->bind($key, $resolver);
    }

    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }
}
