<?php

namespace NatePage\HtmlElement;

use HtmlGenerator\Markup;

interface ElementInterface
{
    /**
     * Set element type.
     *
     * @param null|string $type The element type
     *
     * @return ElementInterface
     */
    public function setType($type = null);

    /**
     * Get element type.
     *
     * @return null|string
     */
    public function getType();

    /**
     * Set element text.
     *
     * @param null|string $text The text element
     *
     * @return ElementInterface
     */
    public function setText($text = null);

    /**
     * Get element text.
     *
     * @return null|string
     */
    public function getText();

    /**
     * Add element attribute.
     *
     * @param string $key   The attribute key
     * @param string $value The attribute value
     *
     * @return ElementInterface
     */
    public function addAttribute($key, $value);

    /**
     * Add element attributes.
     *
     * @param array $attributes The attributes array to add
     *
     * @return ElementInterface
     */
    public function addAttributes(array $attributes);

    /**
     * Set element attributes.
     *
     * @param array $attributes The attributes array to set
     *
     * @return ElementInterface
     */
    public function setAttributes(array $attributes = array());

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Add element child.
     *
     * @param ElementInterface $child The child to add
     *
     * @return ElementInterface
     */
    public function addChild(ElementInterface $child);

    /**
     * Add element children.
     *
     * @param array $children The children array to add
     *
     * @return ElementInterface
     */
    public function addChildren(array $children);

    /**
     * Set element children.
     *
     * @param array $children The children array to set
     *
     * @return ElementInterface
     */
    public function setChildren(array $children = array());

    /**
     * Get element children.
     *
     * @return array
     */
    public function getChildren();

    /**
     * Set element parent.
     *
     * @param ElementInterface|null $parent The element parent to set
     *
     * @return ElementInterface
     */
    public function setParent(ElementInterface $parent = null);

    /**
     * Get element parent.
     *
     * @return ElementInterface|null
     */
    public function getParent();

    /**
     * Render element.
     *
     * @param Markup|null $root The element container
     *
     * @return Markup
     */
    public function render(Markup $root = null);

    /**
     * Render the all parents structure.
     *
     * @return Markup
     */
    public function renderRoot();

    /**
     * Get the string representation.
     *
     * @return string
     */
    public function __toString();
}
