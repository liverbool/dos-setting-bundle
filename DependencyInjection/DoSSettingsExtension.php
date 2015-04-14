<?php

namespace DoS\SettingsBundle\DependencyInjection;

use DoS\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class DoSSettingsExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        list($config) = $this->configure($configs, new Configuration(), $container,
            self::CONFIGURE_LOADER |
            self::CONFIGURE_DATABASE |
            self::CONFIGURE_PARAMETERS |
            self::CONFIGURE_VALIDATORS |
            self::CONFIGURE_FORMS
        );
    }

    /**
     * @inheritdoc
     */
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        // use the Configuration class to generate a config array with
        $config = $this->processConfiguration(new Configuration(), $configs);

        foreach ($config['classes'] as &$cls) {
            if (array_key_exists('interface', $cls)) {
                unset($cls['interface']);
            }

            if (array_key_exists('form', $cls)) {
                unset($cls['form']);
            }
        }

        $container->prependExtensionConfig('sylius_settings', array(
            'classes' => $config['classes'],
        ));
    }
}
