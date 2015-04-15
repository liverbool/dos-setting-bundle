<?php

namespace DoS\SettingsBundle\Schema;

use DoS\SettingsBundle\Resolver\AbstractResolver;
use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface as BaseSchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;

abstract class AbstractSchema implements BaseSchemaInterface
{
    /**
     * @var AbstractResolver
     */
    private $resolver;

    /**
     * @param AbstractResolver $resolver
     */
    public function __construct(AbstractResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @inheritdoc
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $this->resolver->buildSettings($builder);
    }
}
