<?php

namespace App;

/**
 * Class Container
 * @package App
 */
class Container implements \ArrayAccess
{
    /**
     * @var array
     */
    private $definition;

    /**
     * @var array
     */
    private $instances;

    /**
     * Container constructor.
     * @param array $definition
     */
    public function __construct(array $definition)
    {
        $this->definition = $definition;
        $this->instances = [];
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws \ErrorException
     */
    public function get(string $alias)
    {
        if (array_key_exists($alias, $this->instances)) {
            return $this->instances[$alias];
        }

        if (!$this->has($alias)) {
            throw new \ErrorException('Service not found');
        }

        $providerCallback = $this->definition[$alias];
        $service = $providerCallback($this);

        return $this->instances[$alias] = $service;
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function has(string $alias)
    {
        return array_key_exists($alias, $this->definition);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return \ErrorException
     */
    public function offsetSet($offset, $value)
    {
        return new \ErrorException('Set access can not implemented for Container class.');
    }

    /**
     * @param mixed $offset
     * @return \ErrorException
     */
    public function offsetUnset($offset)
    {
        return new \ErrorException('Unset can not be implemented for Container class.');
    }
}
