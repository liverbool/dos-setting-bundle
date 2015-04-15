<?php

namespace DoS\SettingsBundle\Schema;

use DoS\SettingsBundle\Resolver\AbstractResolver;
use DoS\SettingsBundle\Resolver\SettingsResolver;
use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface as BaseSchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;

abstract class AbstractSchema implements BaseSchemaInterface
{
    /**
     * @var AbstractResolver
     */
    protected $resolver;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @param SettingsResolver $settingsResolver
     */
    public function __construct(SettingsResolver $settingsResolver)
    {
        $this->resolver = $settingsResolver->get($this->getNamespace());
    }

    /**
     * @inheritdoc
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $this->resolver->buildSettings($builder);
    }

    /**
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
