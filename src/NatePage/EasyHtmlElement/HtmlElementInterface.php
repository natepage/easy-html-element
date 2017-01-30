<?php

namespace NatePage\EasyHtmlElement;

use NatePage\EasyHtmlElement\Exception\InvalidElementException;
use NatePage\EasyHtmlElement\Exception\UndefinedElementException;

interface HtmlElementInterface
{
    /**
     * Load a html element.
     *
     * @param string|array $name       The element name
     * @param string|null  $text       The element text
     * @param array        $attributes The element attributes
     * @param array        $parameters The element parameters
     * @param array        $extras     The element extras
     * @param array        $children   The element children
     *
     * @return ElementInterface
     */
    public function load(
        $name,
        $text = null,
        array $attributes = array(),
        array $parameters = array(),
        array $extras = array(),
        array $children = array()
    ): ElementInterface;

    /**
     * Check if an element exits.
     *
     * @param string $name The element name
     *
     * @return bool
     */
    public function exists(string $name): bool;

    /**
     * Set the elements map.
     *
     * @param array $map The elements map
     *
     * @return HtmlElementInterface
     */
    public function setMap(array $map): self;

    /**
     * Get the elements map.
     *
     * @return array
     */
    public function getMap(): array;

    /**
     * Add one element to the map.
     *
     * @param string $name    The element name
     * @param array  $element The element array to add
     *
     * @return HtmlElementInterface
     */
    public function addOneToMap(string $name, array $element): self;

    /**
     * Add many elements to the map.
     *
     * @param array $elements The elements to add
     *
     * @return HtmlElementInterface
     */
    public function addManyToMap(array $elements): self;

    /**
     * Set the HtmlElement branch validator.
     *
     * @param BranchValidatorInterface $branchValidator The branch validator to set
     *
     * @return HtmlElementInterface
     */
    public function setBranchValidator(BranchValidatorInterface $branchValidator): self;

    /**
     * Get the HtmlElement branch validator.
     *
     * @return BranchValidatorInterface
     */
    public function getBranchValidator(): BranchValidatorInterface;

    /**
     * Set the HtmlElement escaper.
     *
     * @param EscaperInterface $escaper The escaper to set
     *
     * @return HtmlElementInterface
     */
    public function setEscaper(EscaperInterface $escaper): self;

    /**
     * Get the HtmlElement escaper.
     *
     * @return EscaperInterface
     */
    public function getEscaper(): EscaperInterface;

    /**
     * Get the current element representation.
     *
     * @param string|array $name The element name
     *
     * @return array
     *
     * @throws InvalidElementException   If the current element is defined dynamically and doesn't define a name
     * @throws UndefinedElementException If the current element doesn't exist
     */
    public function getCurrentElement($name): array;
}
