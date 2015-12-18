<?php

namespace DoS\SettingsBundle\DependencyInjection;

use DoS\ResourceBundle\DependencyInjection\AbstractResourceConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends AbstractResourceConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $this->setDefaults($treeBuilder->root('dos_settings'), array(
            'resources' => array(
                'parameter' => array(
                    'classes' => array(
                        'model' => 'DoS\SettingsBundle\Model\SettingParameter',
                    ),
                ),
            )
        ));

        return $treeBuilder;
    }
}
