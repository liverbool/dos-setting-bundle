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
        $rootNode = $treeBuilder->root('dos_settings');

        $this->addDefaults($rootNode, 'doctrine/orm', 'default', array());

        $rootNode
            ->append($this->createResourcesSection(array(
                'parameter' => array(
                    'model' => 'DoS\SettingsBundle\Model\SettingParameter',
                ),
            )))
        ;

        return $treeBuilder;
    }
}
