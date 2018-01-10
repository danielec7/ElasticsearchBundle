<?php

namespace Ijanki\Bundle\ElasticsearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ijanki_elasticsearch');

        $rootNode
            ->fixXmlConfig('client')
            ->children()
                ->arrayNode('clients')
                    ->useAttributeAsKey('id')
                    ->arrayPrototype()
                        ->children()
                            ->arrayNode('hosts')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->performNoDeepMerging()
                                ->scalarPrototype()->end()
                            ->end()
                            ->integerNode('retries')->end()
                            ->scalarNode('logger')->end()
                            ->scalarNode("connectionPool")->end()
                            ->scalarNode("selector")->end()
                            ->scalarNode("serializer")->end()
                            ->scalarNode("connectionFactory")->end()
                            ->scalarNode("endpoint")->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}