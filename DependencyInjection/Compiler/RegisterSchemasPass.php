<?php

namespace DoS\SettingsBundle\DependencyInjection\Compiler;

use DoS\SettingsBundle\Schema\AbstractSchema;
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

        $resolvers = $container->getDefinition('dos.settings.resolver');

        foreach ($container->findTaggedServiceIds('dos.settings_resolver') as $id => $attributes) {
            $resolvers->addMethodCall('add', array(new Reference($id)));
            $resolver = $container->getDefinition($id);
            $resolver->addMethodCall('setDefaultOptions', $attributes[0]['defaults']);
            $resolver->addMethodCall('setSettingsHelper', $container->getDefinition('dos.settings'));
        }

        $schemaRegistry = $container->getDefinition('sylius.settings.schema_registry');

        foreach ($container->findTaggedServiceIds('dos.settings_schema') as $id => $attributes) {
            if (!array_key_exists('namespace', $attributes[0])) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must define the "namespace" attribute on "sylius.settings_schema" tags.', $id));
            }

            $namespace = $attributes[0]['namespace'];
            $schema = $container->getDefinition($id);

            if (in_array(AbstractSchema::class, class_parents($schema->getClass()))) {
                $schema->addMethodCall('setNamespace', array($namespace));
            }

            $schemaRegistry->addMethodCall('registerSchema', array($namespace, new Reference($id)));
        }
    }
}
