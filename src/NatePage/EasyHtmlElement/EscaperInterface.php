<?php

namespace NatePage\EasyHtmlElement;

interface EscaperInterface
{
    /**
     * Apply escaping strategies to an element.
     *
     * @param ElementInterface $element The element to escape
     *
     * @return ElementInterface
     */
    public function escape(ElementInterface $element);

    /**
     * Apply escaping strategies on element attributes.
     *
     * @param array $attributes The attributes array to escape
     *
     * @return array
     */
    public function escapeAttributes(array $attributes);

    /**
     * Apply url escaping strategy on an url parameter.
     *
     * @param string $parameter The parameter to escape
     *
     * @return string
     */
    public function escapeUrlParameter($parameter);

    /**
     * Get the urls attributes.
     *
     * @return array
     */
    public function getUrlsAttributes();
}