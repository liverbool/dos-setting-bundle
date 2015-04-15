<?php

namespace DoS\SettingsBundle\Resolver;

class SettingsResolver implements \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    protected $resolvers = array();

    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param AbstractResolver $resolver
     *
     * @return $this
     */
    public function add(AbstractResolver $resolver)
    {
        $this->offsetSet($resolver->getNamespace(), $resolver);

        return $this;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->resolvers);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->resolvers[$offset];
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->resolvers[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->resolvers[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->resolvers);
    }
}
