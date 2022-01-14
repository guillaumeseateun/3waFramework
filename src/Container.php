<?php

namespace Framework;

use ArrayAccess;

class Container implements ArrayAccess
{
    protected $p = [];

    public function offsetSet($k, $v): void
    {
        if (isset($this->p[$k])) {
            throw new \RuntimeException(\sprintf('Cannot override frozen service "%s".', $k));
        }

        $this->p[$k] = $v;
    }

    public function offsetGet($k)
    {

        if (!isset($this->p[$k])) {
            throw new \InvalidArgumentException(\sprintf('unknow value: %s', $k));
        }

        if (is_callable($this->p[$k])) {
            return $this->p[$k]($this);
        }

        return $this->p[$k];
    }

    public function offsetExists($id): bool
    {
        return isset($this->p[$id]);
    }

    public function offsetUnset($id): void
    {
        if (isset($this->p[$id])) {
            unset($this->p[$id]);
        }
    }

    public function asShared(\Closure $callable)
    {

        return function ($c) use ($callable) {
            static $o;
            if (is_null($o)) {
                $o = $callable($c);
            }
            return $o;
        };
    }
}
