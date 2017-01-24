<?php

namespace NatePage\EasyHtmlElement\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('easy_html_element');

        $rootNode
            ->children()
                ->arrayNode('map')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
