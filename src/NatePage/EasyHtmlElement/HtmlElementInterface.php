<?php

namespace NatePage\EasyHtmlElement;

use NatePage\EasyHtmlElement\Exception\InvalidElementException;
use NatePage\EasyHtmlElement\Exception\UndefinedElementException;

interface HtmlElementInterface
{
    /**
     * Create a html element.
     *
     * @param string $type       The element type
     * @param string $text       The element text
     * @param array  $attributes The element attributes
     * @param array  $children   The element children
     *
     * @return ElementInterface
     */
    public static function create($type = null, $text = null, array $attributes = array(), array $children = array());

    /**
     * Load a html element.
     *
     * @param string $name       The element name
     * @param array  $parameters The element parameters
     * @param array  $attributes The element attributes
     * @param array  $children   The element children
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
     * @param string $name    The element name
     * @param array  $element The element array to add
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
     * Set the HtmlElement branch validator.
     *
     * @param BranchValidatorInterface $branchValidator The branch validator to set
     *
     * @return HtmlElementInterface
     */
    public function setBranchValidator(BranchValidatorInterface $branchValidator);

    /**
     * Get the HtmlElement branch validator.
     *
     * @return BranchValidatorInterface
     */
    public function getBranchValidator();

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
     * Get the current element representation.
     *
     * @param string $name The element name
     *
     * @return array
     *
     * @throws InvalidElementException   If the current element is defined dynamically and doesn't define a name
     * @throws UndefinedElementException If the current element doesn't exist
     */
    public function getCurrentElement($name);
}
