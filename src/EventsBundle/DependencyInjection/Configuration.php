<?php

namespace SWP\EventsBundle\DependencyInjection;

use SWP\Bundle\StorageBundle\Doctrine\ORM\EntityRepository;
use SWP\Component\Bridge\Model\Event;
use SWP\Component\Storage\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
        $treeBuilder->root('swp_events')
            ->children()
                ->arrayNode('persistence')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('orm')
                            ->addDefaultsIfNotSet()
                            ->canBeEnabled()
                            ->children()
                                ->arrayNode('classes')
                                ->addDefaultsIfNotSet()
                                ->children()
//                                    ->arrayNode('event')
//                                        ->addDefaultsIfNotSet()
//                                        ->children()
//                                            ->scalarNode('model')->cannotBeEmpty()->defaultValue(Event::class)->end()
//                                            ->scalarNode('repository')->defaultValue(EntityRepository::class)->end()
//                                            ->scalarNode('factory')->defaultValue(Factory::class)->end()
//                                            ->scalarNode('interface')->defaultValue(null)->end()
//                                            ->scalarNode('object_manager_name')->defaultValue(null)->end()
//                                        ->end()
//                                    ->end()
                                ->end() // classes
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
