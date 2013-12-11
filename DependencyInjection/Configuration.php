<?php

/*
 * This file is part of the CleentfaarCIBundle package.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cleentfaar\Bundle\CIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cleentfaar_ci');
        $rootNode
            ->children()
                ->arrayNode('travis')
                    ->children()
                        ->booleanNode('enabled')->defaultValue(false)->end()
                        ->arrayNode('shields')
                            ->prototype('array')
                                ->beforeNormalization()
                                    ->ifArray()
                                    ->then(function($v) {
                                        $v['enabled'] = true;
                                        return $v;
                                    })
                                ->end()
                                ->beforeNormalization()
                                    ->ifTrue()
                                    ->then(function($v) {
                                        $v = array(
                                            'enabled' => true,
                                        );
                                        return $v;
                                    })
                                ->end()
                                ->children()
                                    ->booleanNode('enabled')->defaultValue(true)->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function($v) {
                            $v['enabled'] = true;
                            return $v;
                        })
                    ->end()
                ->end()
                ->arrayNode('scrutinizer')
                    ->children()
                        ->booleanNode('enabled')->defaultValue(false)->end()
                        ->arrayNode('shields')
                            ->prototype('array')
                                ->beforeNormalization()
                                    ->ifArray()
                                    ->then(function($v) {
                                        if ($v['hash'] != '') {
                                            $v['enabled'] = true;
                                        }
                                        return $v;
                                    })
                                ->end()
                                ->children()

                                    ->booleanNode('enabled')->defaultValue(false)->end()
                                    ->scalarNode('hash')->isRequired()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function($v) {
                            $v['enabled'] = true;
                            return $v;
                        })
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
