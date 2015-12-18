<?php

namespace DoS\SettingsBundle\DependencyInjection;

use DoS\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class DoSSettingsExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getBundleConfiguration()
    {
        return new Configuration();
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        // use the Configuration class to generate a config array with
        $config = $this->processConfiguration(new Configuration(), $configs);

        // no need for sylius
        foreach ($config['resources'] as &$resources) {
            foreach($resources as &$classes) {
                if (array_key_exists('interface', $classes)) {
                    unset($classes['interface']);
                }

                if (array_key_exists('form', $classes)) {
                    unset($classes['form']);
                }
            }

            if (array_key_exists('validation_groups', $resources)) {
                unset($resources['validation_groups']);
            }
        }

        $container->prependExtensionConfig('sylius_settings', array(
            'resources' => $config['resources'],
        ));
    }
}
