<?php

namespace Core;

class Container
{
    protected $bindings = [];

    // bind/add something into the container
    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    // grab things out of the container
    public function resolve($key)
    {
        if (!array_key_exists($key, $this->bindings)) {
            throw new \Exception("No matching binding found for {$key}");
        }

        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}
