<?php

namespace NatePage\EasyHtmlElement;

interface HtmlElementInterface
{
    /**
     * Create a html element.
     *
     * @param string $type      The element type
     * @param string $text      The element text
     * @param array $attributes The element attributes
     * @param array $children   The element children
     *
     * @return ElementInterface
     */
    public static function create($type = null, $text = null, array $attributes = array(), array $children = array());

    /**
     * Load a html element.
     *
     * @param string $name      The element name
     * @param array $parameters The element parameters
     * @param array $attributes The element attributes
     * @param array $children   The element children
     *
     * @return ElementInterface
     */
    public function load($name, array $parameters = array(), array $attributes = array(), array $children = array());

    /**
     * Check if an element exits.
     *
     * @param string $name The element name
     *
     * @return bool
     */
    public function exists($name);

    /**
     * Set the elements map.
     *
     * @param array $map The elements map
     *
     * @return HtmlElementInterface
     */
    public function setMap(array $map);

    /**
     * Get the elements map.
     *
     * @return array
     */
    public function getMap();

    /**
     * Add one element to the map.
     *
     * @param string $name   The element name
     * @param array $element The element array to add
     *
     * @return HtmlElementInterface
     */
    public function addOneToMap($name, array $element);

    /**
     * Add many elements to the map.
     *
     * @param array $elements The elements to add
     *
     * @return HtmlElementInterface
     */
    public function addManyToMap(array $elements);

    /**
     * Set the HtmlElement escaper.
     *
     * @param EscaperInterface $escaper The escaper to set
     *
     * @return HtmlElementInterface
     */
    public function setEscaper(EscaperInterface $escaper);

    /**
     * Get the HtmlElement escaper.
     *
     * @return EscaperInterface
     */
    public function getEscaper();

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
     * Determine if html is escaped or not
     *
     * @param bool $escapeHtml
     *
     * @return HtmlElementInterface
     */
    public function setEscapeHtml($escapeHtml = true);

    /**
     * Get the html escaping strategy.
     *
     * @return bool
     */
    public function isEscapeHtml();

    /**
     * Determine if html attributes are escaped or not
     *
     * @param bool $escapeHtmlAttr
     *
     * @return HtmlElementInterface
     */
    public function setEscapeHtmlAttr($escapeHtmlAttr = true);

    /**
     * Get the html attributes escaping strategy.
     *
     * @return bool
     */
    public function isEscapeHtmlAttr();

    /**
     * Determine if javascript is escaped or not
     *
     * @param bool $escapeJs
     *
     * @return HtmlElementInterface
     */
    public function setEscapeJs($escapeJs = true);

    /**
     * Get the javascript escaping strategy.
     *
     * @return bool
     */
    public function isEscapeJs();

    /**
     * Determine if css is escaped or not
     *
     * @param bool $escapeCss
     *
     * @return HtmlElementInterface
     */
    public function setEscapeCss($escapeCss = true);

    /**
     * Get the css escaping strategy.
     *
     * @return bool
     */
    public function isEscapeCss();

    /**
     * Determine if urls are escaped or not
     *
     * @param bool $escapeUrl
     *
     * @return HtmlElementInterface
     */
    public function setEscapeUrl($escapeUrl = true);

    /**
     * Get the urls escaping strategy.
     *
     * @return bool
     */
    public function isEscapeUrl();
}
