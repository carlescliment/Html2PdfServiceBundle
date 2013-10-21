<?php

namespace carlescliment\Html2PdfServiceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('html2pdf');
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('host')->cannotBeEmpty()->end()
                ->scalarNode('port')->cannotBeEmpty()->end()
            ->end()
        ;
        return $treeBuilder;
    }
}