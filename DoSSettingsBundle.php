<?php

namespace DoS\SettingsBundle;

use DoS\ResourceBundle\DependencyInjection\AbstractResourceBundle;
use DoS\SettingsBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoSSettingsBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $builder)
    {
        parent::build($builder);

        $builder->addCompilerPass(new Compiler\RegisterSchemasPass());
    }
}
