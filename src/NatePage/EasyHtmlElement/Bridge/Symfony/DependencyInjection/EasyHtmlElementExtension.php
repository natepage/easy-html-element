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
    const TWIG_EXTENSION_NAME = self::SERVICE_NAME.'.twig_extension';
    const ESCAPER_NAME = self::SERVICE_NAME.'.escaper';
    const BRANCH_VALIDATOR_NAME = self::SERVICE_NAME.'.branch_validator';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = new Configuration();
        $config = $this->processConfiguration($config, $configs);

        $this->registerEscaper($config, $container);
        $this->registerBranchValidator($config, $container);
        $this->registerHtmlElement($config, $container);
        $this->registerTwigExtenstion($container);
    }

    /**
     * Register EasyHtmlElement service.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function registerHtmlElement(array $config, ContainerBuilder $container)
    {
        $htmlElementDef = new Definition(HtmlElement::class, array($config['map'], null, null, $config['encoding']));

        $htmlElementDef
            ->addMethodCall('setEscaper', array(new Reference(self::ESCAPER_NAME)))
            ->addMethodCall('setBranchValidator', array(new Reference(self::BRANCH_VALIDATOR_NAME)))
        ;

        $container->setDefinition(self::SERVICE_NAME, $htmlElementDef);
    }

    /**
     * Register Escaper service.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function registerEscaper(array $config, ContainerBuilder $container)
    {
        $escaperDef = new Definition($config['escaper']);

        $escaperDef
            ->addMethodCall('setEscapeHtml', array($config['escaping']['html']))
            ->addMethodCall('setEscapeHtmlAttr', array($config['escaping']['html_attr']))
            ->addMethodCall('setEscapeCss', array($config['escaping']['css']))
            ->addMethodCall('setEscapeJs', array($config['escaping']['js']))
            ->addMethodCall('setEscapeUrl', array($config['escaping']['url']))
        ;

        $container->setDefinition(self::ESCAPER_NAME, $escaperDef);
    }

    /**
     * Register Branch Validator service.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function registerBranchValidator(array $config, ContainerBuilder $container)
    {
        $branchValidatorDef = new Definition($config['branch_validator'], array(new Reference(self::SERVICE_NAME)));

        $container->setDefinition(self::BRANCH_VALIDATOR_NAME, $branchValidatorDef);
    }

    /**
     * Register Twig extension.
     *
     * @param ContainerBuilder $container
     */
    public function registerTwigExtenstion(ContainerBuilder $container)
    {
        $container
            ->setDefinition(self::TWIG_EXTENSION_NAME, new Definition(
                TwigExtension::class, array(new Reference(self::SERVICE_NAME))
            ))
            ->addTag('twig.extension')
            ->setPublic(false)
        ;
    }
}
