<?php

namespace NatePage\EasyHtmlElement\Bridge\Symfony\DependencyInjection;

use NatePage\EasyHtmlElement\BranchValidator;
use NatePage\EasyHtmlElement\Escaper;
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
                ->scalarNode('encoding')->defaultValue('utf-8')->end()
                ->scalarNode('escaper')->defaultValue(Escaper::class)->end()
                ->scalarNode('branch_validator')->defaultValue(BranchValidator::class)->end()
                ->arrayNode('escaping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('html')->defaultTrue()->end()
                        ->booleanNode('html_attr')->defaultTrue()->end()
                        ->booleanNode('css')->defaultTrue()->end()
                        ->booleanNode('js')->defaultTrue()->end()
                        ->booleanNode('url')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('map')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('type')->end()
                            ->scalarNode('text')->end()
                            ->scalarNode('parent')->end()
                            ->variableNode('attr')->end()
                            ->variableNode('children')->end()
                            ->variableNode('extends')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
