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
}
