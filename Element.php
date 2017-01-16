<?php

namespace NatePage\EasyHtmlElement;

use HtmlGenerator\HtmlTag;
use HtmlGenerator\Markup;

class Element implements ElementInterface
{
    /** @var string  */
    protected $type;

    /** @var string */
    protected $text;

    /** @var array */
    protected $attributes;

    /** @var array */
    protected $children;

    /** @var ElementInterface */
    protected $parent;

    public function __construct($type = null, $text = null, array $attributes = array(), array $children = array())
    {
        $this->setType($type);
        $this->setText($text);
        $this->setChildren($children);

        $this->attributes = $attributes;
    }

    public function __toString()
    {
        return (string) $this->renderRoot();
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type = null)
    {
        if(null !== $type){
            $this->type = $type;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setText($text = null)
    {
        if(null != $text){
            $this->text = $text;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributes(array $attributes)
    {
        foreach($attributes as $key => $value){
            $this->addAttribute($key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes = array())
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(ElementInterface $child)
    {
        $this->children[] = $child;

        $child->setParent($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addChildren(array $children)
    {
        foreach($children as $child){
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren(array $children = array())
    {
        $this->children = array();

        $this->addChildren($children);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(ElementInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function renderRoot()
    {
        return null !== $this->parent ? $this->parent->renderRoot() : $this->render();
    }

    /**
     * {@inheritdoc}
     */
    public function render(Markup $root = null)
    {
        $type = $this->type;
        $attributes = $this->attributes;

        $element = null === $root ? HtmlTag::createElement($type) : $root->addElement($type);
        $element->text($this->text);

        $this->renderAttributes($element, $attributes);
        $this->renderChildren($element);

        return $element;
    }

    /**
     * Render element children.
     *
     * @param Markup $root
     */
    private function renderChildren(Markup $root)
    {
        foreach($this->children as $child){
            $child->render($root);
        }
    }

    /**
     * Set Markup element attributes.
     *
     * @param Markup $element
     * @param array $attributes
     */
    private function renderAttributes(Markup $element, array $attributes)
    {
        foreach($attributes as $attr => $value){
            if(is_array($value)){
                $glue = 'style' == $attr ? '; ' : ' ';
                $value = implode($glue, $value);
            }

            if(null !== $value){
                $element->set($attr, $value);
            }
        }
    }
}
