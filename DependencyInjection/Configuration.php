<?php

namespace TuanQuynh\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tuanquynh_user');

        //$this->addWebServicesSection($rootNode);

        return $treeBuilder;
    }
    /**
     * Adds soap client section to config.
     *
     * @param ArrayNodeDefinition $root The root element for the config nodes.
     */
    protected function addWebServicesSection(ArrayNodeDefinition $root)
    {
    }
}
