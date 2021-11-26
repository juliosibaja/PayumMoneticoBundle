<?php

namespace Codatte\Bundle\PayumMoneticoBundle\DependencyInjection;

use Ekyna\Component\Payum\Monetico\Api\Api;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class Configuration
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte Team <devteam@codatte.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        if (version_compare(Kernel::VERSION, '4.0.0') >= 0 ) {
            $treeBuilder = new TreeBuilder('payum_monetico');
            $root = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $root = $treeBuilder->root('payum_monetico');
        }

        $this->addApiSection($root);

        return $treeBuilder;
    }

    /**
     * Adds the api configuration section.
     *
     * @param ArrayNodeDefinition $node
     */
    public function addApiSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('api')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->enumNode('mode')
                                ->isRequired()
                                ->values([Api::MODE_TEST, Api::MODE_PRODUCTION])
                            ->end()
                            ->scalarNode('tpe')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('key')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('company')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->booleanNode('debug')
                                ->defaultValue('%kernel.debug%')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
