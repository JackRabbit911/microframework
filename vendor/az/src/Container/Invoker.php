<?php

declare(strict_types=1);

namespace Sys\Container;

use Psr\Container\ContainerInterface;
use Closure;
use ReflectionFunction;
use ReflectionMethod;

class Invoker
{
    public function __construct(private ContainerInterface $c){}

    public function call(callable $callable, array $args)
    {
        [$class, $method] = $this->getRef($callable);
        $args = $this->getArgs($method, $args);

        return $method->invokeArgs($class, $args);
    }

    private function getRef($callable)
    {
        if (is_array($callable)) {
            [$class, $method] = $callable;
            return [$class, new ReflectionMethod($class, $method)];
        }

        if (is_object($callable)) {
            return [$callable, new ReflectionMethod($callable, '__invoke')];
        }

        if ($callable instanceof Closure) {
            return [null, new ReflectionFunction($callable)];
        }
    }

    private function getArgs($ref, $args)
    {
        $params = $ref->getParameters();

        foreach ($params as $param) {
            $name = $param->getName();

            if (!array_key_exists($name, $args)) {
                $type = $param->getType()?->getName();
    
                if ($type) {
                    $instance = $this->c->get($type);
                    $args[$param->getName()] = $instance;
                }   
            }
        }

        return $args;
    }
}
