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
    static public function create($type = null, $text = null, array $attributes = array(), array $children = array());

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
}
