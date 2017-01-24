<?php

namespace NatePage\EasyHtmlElement\Bridge\Twig;

use NatePage\EasyHtmlElement\HtmlElementInterface;
use NatePage\EasyHtmlElement\ElementInterface;

class EasyHtmlElementExtension extends \Twig_Extension
{
    /** @var HtmlElementInterface */
    private $htmlElement;

    public function __construct(HtmlElementInterface $htmlElement)
    {
        $this->htmlElement = $htmlElement;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return array(
            new \Twig_Function('htmlElement', array($this, 'load'), array('is_safe' => array('html')))
        );
    }

    /**
     * Load a html element.
     *
     * @param string|array $name       The element name
     * @param array        $parameters The element parameters
     * @param array        $attributes The element attributes
     * @param array        $children   The element children
     *
     * @return ElementInterface
     */
    public function load(
        $name,
        array $parameters = array(),
        array $attributes = array(),
        array $children = array()
    ): ElementInterface
    {
        return $this->htmlElement->load($name, $parameters, $attributes, $children);
    }
}
