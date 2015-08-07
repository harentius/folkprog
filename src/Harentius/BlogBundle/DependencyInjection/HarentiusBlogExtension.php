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
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('services-repositories.yml');
        $loader->load('services-admin.yml');

        $twigExtensionDefinition = $container->getDefinition('harentius_blog.twig.blog_extension');
        $cacheService = ($config['sidebar']['cache_filefime'] === null)
            ? 'harentius_blog.array_cache'
            : 'harentius_blog.sidebar.cache'
        ;

        $twigExtensionDefinition->replaceArgument(1, $container->getDefinition($cacheService));

        $container->setParameter('harentius_blog.sidebar.tags_limit', $config['sidebar']['tags_limit']);
        $container->setParameter('harentius_blog.sidebar.tag_sizes', $config['sidebar']['tag_sizes']);
        $container->setParameter('harentius_blog.homepage.page_slug', $config['homepage']['page_slug']);
        $container->setParameter('harentius_blog.homepage.feed.category', $config['homepage']['feed']['category']);
        $container->setParameter('harentius_blog.homepage.feed.number', $config['homepage']['feed']['number']);
        $container->setParameter('harentius_blog.list.posts_per_page', $config['list']['posts_per_page']);
    }
}