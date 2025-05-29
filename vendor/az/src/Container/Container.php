<?php

declare(strict_types=1);

namespace Sys\Container;

use Psr\Container\ContainerInterface;
use Closure;
use ErrorException;
use ReflectionClass;

class Container implements ContainerInterface
{
    private array $definisions = [];
    private Invoker $invoker;

    public function __construct()
    {
        $this->definisions[ContainerInterface::class] = $this;
        $this->invoker = new Invoker($this);
    }

    public function addDefinitions(...$definisions)
    {
        foreach ($definisions as $item) {
            if (is_string($item)) {
                if (!is_file($item)) {
                    throw new ErrorException("File: $item not found");
                }

                $item = require_once $item;
            }

            if (is_array($item)) {
                $this->definisions = array_replace($this->definisions, $item);
            }
        }
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->definisions)) {
            if (class_exists($key)) {
                $this->definisions[$key] = $this->getInstance($key);
            } else {
                throw new ErrorException(sprintf('Undefined array key "%s"', $key));
            }
        }

        if ($this->definisions[$key] instanceof Closure) {
            $this->definisions[$key] = $this->definisions[$key]();
        }
        
        return $this->definisions[$key];
    }

    public function has($key): bool
    {
        return isset($this->definisions[$key]);
    }

    public function call($callable, $args)
    {
        return $this->invoker->call($callable, $args);
    }

    private function getInstance($class)
    {
        $reflect_class  = new ReflectionClass($class);
        $reflect_construct = $reflect_class->getConstructor();

        if (!$reflect_construct) {
            return new $class;
        }

        $reflect_params = $reflect_construct->getParameters();

        $args = [];

        foreach ($reflect_params as $reflect_param) {
            $reflect_type = $reflect_param->getType();
            $key = $reflect_type->getName();

            if (!$reflect_type->isBuiltin()) {
                $args[] = $this->get($key);
            } else {
                $args[] = $key;
            }
        }

        return $reflect_class->newInstanceArgs($args);
    }
}
