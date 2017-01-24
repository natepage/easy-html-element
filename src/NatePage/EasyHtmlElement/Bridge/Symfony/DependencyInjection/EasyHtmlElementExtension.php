<?php

namespace NatePage\EasyHtmlElement\Bridge\Symfony\DependencyInjection;

use NatePage\EasyHtmlElement\HtmlElement;
use NatePage\EasyHtmlElement\Bridge\Twig\EasyHtmlElementExtension as TwigExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class EasyHtmlElementExtension extends Extension
{
    const SERVICE_NAME = 'easy_html_element';
    const TWIG_EXTENSION_NAME = 'easy_html_element.twig_extension';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = new Configuration();
        $config = $this->processConfiguration($config, $configs);

        $map = $config['map'];

        $container->setDefinition(self::SERVICE_NAME, new Definition(HtmlElement::class, array($map)));

        $container
            ->setDefinition(self::TWIG_EXTENSION_NAME, new Definition(
                TwigExtension::class, array(new Reference(self::SERVICE_NAME))
            ))
            ->addTag('twig.extension')
            ->setPublic(false)
        ;
    }
}
