<?php

namespace Ijanki\Bundle\ElasticsearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IjankiElasticsearchExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['clients'])) {
            foreach ($config['clients'] as $clientName => $clientConfig) {
                $this->createClient($container, $clientName, $clientConfig);
            }
        }
    }

    protected function createClient(ContainerBuilder $container, $clientName, $config)
    {
        $c = [
            'hosts' => $config['hosts'],
        ];

        if (isset($config['retries'])) {
            $c['retries'] = $config['retries'];
        }

        $definition = new Definition();
        $definition->setClass('Elasticsearch\Client');
        $definition->setFactory(['Elasticsearch\ClientBuilder', 'fromConfig']);
        $definition->setArguments([$c]);
        $definition->setPublic(true);

        $container->setDefinition('ijanki_elasticsearch.'.$clientName, $definition);
    }
}