<?php

namespace DoS\SettingsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterSchemasPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sylius.settings.schema_registry')) {
            return;
        }

        $schemaRegistry = $container->getDefinition('sylius.settings.schema_registry');

        foreach ($container->findTaggedServiceIds('dos.settings_schema') as $id => $attributes) {
            if (!array_key_exists('namespace', $attributes[0])) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must define the "namespace" attribute on "sylius.settings_schema" tags.', $id));
            }

            $namespace = $attributes[0]['namespace'];

            $schemaRegistry->addMethodCall('registerSchema', array($namespace, new Reference($id)));
        }
    }
}
