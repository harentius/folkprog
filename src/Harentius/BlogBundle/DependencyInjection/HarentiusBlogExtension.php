<?php

namespace Harentius\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class HarentiusBlogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $twigExtensionDefinition = $container->getDefinition('harentius_blog.twig.blog_extension');
        $cacheService = ($container->getParameterBag()->get('sidebar_cache_filefime') === null)
            ? 'harentius_blog.array_cache'
            : 'harentius_blog.sidebar.cache'
        ;

        $twigExtensionDefinition->replaceArgument(1, $container->getDefinition($cacheService));
    }
}
