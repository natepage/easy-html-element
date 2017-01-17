<?php

namespace NatePage\EasyHtmlElement;

use NatePage\EasyHtmlElement\Exception\InvalidArgumentsNumberException;
use NatePage\EasyHtmlElement\Exception\InvalidElementException;
use NatePage\EasyHtmlElement\Exception\UndefinedElementException;

class HtmlElement implements HtmlElementInterface
{
    /** @var array */
    private $map;

    /** @var EscaperInterface */
    private $escaper;

    /** @var array The already resolved elements */
    private $resolved = array();

    /** @var array The default values of element options */
    private $defaults = array(
        'parent' => null,
        'children' => array(),
        'extends' => array(),
        'attr' => array(),
        'text' => null,
        'type' => null,
        'class' => Element::class
    );

    /** @var array The options to check to valid a branch */
    private $checks = array('parent', 'extends', 'children');

    /** @var array The mergeable attributes */
    private $mergeableAttributes = array('class', 'style');

    /** @var array The special escaping types */
    private $specialEscapingTypes = array('script', 'style');

    /** @var bool Determine if html is escaped or not */
    private $escapeHtml = true;

    /** @var bool Determine if html attributes are escaped or not */
    private $escapeHtmlAttr = true;

    /** @var bool Determine if javascript is escaped or not */
    private $escapeJs = true;

    /** @var bool Determine if css is escaped or not */
    private $escapeCss = true;

    /** @var bool Determine if urls are escaped or not */
    private $escapeUrl = true;

    /**
     * HtmlElement constructor.
     *
     * @param array                 $map      The elements map
     * @param EscaperInterface|null $escaper  The escaper, by default ZendFramework/Escaper is used
     * @param string                $encoding The encoding used for escaping, by default utf-8 is used
     */
    public function __construct(array $map = array(), EscaperInterface $escaper = null, $encoding = 'utf-8')
    {
        $this->map = $map;
        $this->escaper = null !== $escaper ? $escaper : new Escaper($encoding);
    }

    /**
     * Create element on static calls.
     *
     * @param string $type      The element type
     * @param array  $arguments The arguments array to set:
     *                          [0] = text (string)
     *                          [1] = attributes (array)
     *                          [2] = children (array)
     *
     * @return ElementInterface
     *
     * @throws InvalidArgumentsNumberException If the arguments length is more than 3
     */
    public static function __callStatic($type, $arguments)
    {
        switch (count($arguments)) {
            case 0:
                return self::create($type);
            case 1:
                return self::create($type, $arguments[0]);
            case 2:
                return self::create($type, $arguments[0], $arguments[1]);
            case 3:
                return self::create($type, $arguments[0], $arguments[1], $arguments[2]);
            default:
                throw new InvalidArgumentsNumberException(sprintf(
                    'Maximum numbers of arguments is %d, [%d] given.',
                    3,
                    count($arguments)
                ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function create($type = null, $text = null, array $attributes = array(), array $children = array())
    {
        $htmlElement = new HtmlElement();

        $attributes = $htmlElement->escapeAttributes($attributes);

        foreach ($children as $key => $child) {
            $children[$key] = $htmlElement->escape($child);
        }

        return $htmlElement->escape(new Element($type, $text, $attributes, $children));
    }

    /**
     * {@inheritdoc}
     */
    public function escapeAttributes(array $attributes)
    {
        if ($this->escapeHtmlAttr || $this->escapeUrl) {
            foreach ($attributes as $attr => $value) {
                if ('href' == $attr) {
                    if ($this->escapeUrl) {
                        $value = $this->escaper->escapeUrl($value);
                    }
                } else {
                    if ($this->escapeHtmlAttr) {
                        $value = $this->escaper->escapeHtmlAttr($value);
                    }
                }

                $attributes[$attr] = $value;
            }
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function escape(ElementInterface $element)
    {
        if ($this->escapeHtml && !in_array($element->getType(), $this->specialEscapingTypes)) {
            $element->setText($this->escaper->escapeHtml($element->getText()));
        }

        $element->setAttributes($this->escapeAttributes($element->getAttributes()));

        if ($this->escapeJs && 'script' == $element->getType()) {
            $element->setText($this->escaper->escapeJs($element->getText()));
        }

        if ($this->escapeCss && 'style' == $element->getType()) {
            $element->setText($this->escaper->escapeCss($element->getText()));
        }

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * {@inheritdoc}
     */
    public function setMap(array $map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addManyToMap(array $elements)
    {
        foreach ($elements as $name => $element) {
            $this->addOneToMap($name, $element);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addOneToMap($name, array $element)
    {
        $this->map[$name] = $element;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscaper(EscaperInterface $escaper)
    {
        $this->escaper = $escaper;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeHtml()
    {
        return $this->escapeHtml;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeHtml($escapeHtml = true)
    {
        $this->escapeHtml = $escapeHtml;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeHtmlAttr()
    {
        return $this->escapeHtmlAttr;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeHtmlAttr($escapeHtmlAttr = true)
    {
        $this->escapeHtmlAttr = $escapeHtmlAttr;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeJs()
    {
        return $this->escapeJs;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeJs($escapeJs = true)
    {
        $this->escapeJs = $escapeJs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeCss()
    {
        return $this->escapeCss;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeCss($escapeCss = true)
    {
        $this->escapeCss = $escapeCss;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeUrl()
    {
        return $this->escapeUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeUrl($escapeUrl = true)
    {
        $this->escapeUrl = $escapeUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load($name, array $parameters = array(), array $attributes = array(), array $children = array())
    {
        $element = $this->getInstance($name, $parameters, true);

        $element->addAttributes($this->escapeAttributes($attributes));

        foreach ($children as $child) {
            $element->addChild($this->escape($child));
        }

        return $element;
    }

    /**
     * Get the element instance.
     *
     * @param string $name       The element name
     * @param array  $parameters The parameters to replace in element
     * @param bool   $mainCall   Determine if it's the main(first) call of the method
     *
     * @return ElementInterface
     *
     * @throws InvalidElementException If the current instance doesn't implement ElementInterface
     */
    private function getInstance($name, array $parameters, $mainCall = false)
    {
        $element = $this->resolveElement($name, $parameters, $mainCall);

        $class = $element['class'];
        $type = $element['type'];
        $text = $element['text'];
        $attributes = $element['attr'];

        $instance = new $class($type, $text, $attributes);

        if (!$instance instanceof ElementInterface) {
            throw new InvalidElementException(sprintf(
                'The element "%s" does not implement the %s',
                get_class($instance),
                ElementInterface::class
            ));
        }

        $children = array();
        foreach ((array)$element['children'] as $child) {
            $children[] = $this->getInstance($child, $parameters);
        }

        $instance->setChildren($children);

        if (null !== $element['parent']) {
            $parent = $this->getInstance($element['parent'], $parameters);

            $parent->addChild($instance);
        }

        return $this->escape($instance);
    }

    /**
     * Get the resolved element representation.
     *
     * @param string $name       The current element name
     * @param array  $parameters The parameters to replace in element
     * @param bool   $mainCall   Determine if it's the main(first) call of the method
     *
     * @return array
     *
     * @throws UndefinedElementException If the current element doesn't exist
     */
    private function resolveElement($name, array $parameters, $mainCall = false)
    {
        $getCurrent = true;
        $current = array();

        if (is_array($name)) {
            $current = $name;
            $name = $current['name'];

            $getCurrent = false;
        }

        if ($this->alreadyResolved($name)) {
            return $this->resolved[$name];
        }

        if ($getCurrent && !$this->exists($name)) {
            throw new UndefinedElementException(sprintf('The element with name "%s" does not exist.', $name));
        }

        if ($mainCall) {
            $this->validBranch($name);
        }

        if ($getCurrent) {
            $current = $this->getCurrentElement($name);
        }

        foreach ($this->defaults as $default => $value) {
            if (!isset($current[$default])) {
                $current[$default] = $value;
            }
        }

        $current = $this->replaceParameters($current, $parameters);

        foreach ((array)$current['extends'] as $extend) {
            $extend = $this->resolveElement($extend, $parameters);
            $current = $this->extendElement($extend, $current);
        }

        $this->resolved[$name] = $current;

        return $current;
    }

    /**
     * Check if an element has been already resolved.
     *
     * @param string $name
     *
     * @return bool
     */
    private function alreadyResolved($name)
    {
        return array_key_exists($name, $this->resolved);
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return array_key_exists(lcfirst($name), $this->map);
    }

    /**
     * Valid the current map branch.
     *
     * @param string $name     The current element name
     * @param array  $circular The array of elements names called in the current branch of map
     *
     * @throws InvalidElementException   If the current element is defined dynamically and doesn't define a name
     *                                   If the current element define a parent, child or extends which creates circular
     *                                   declaration
     * @throws UndefinedElementException If the current element define a parent, child or extends which doesn't exist
     */
    private function validBranch($name, array $circular = array())
    {
        $getCurrent = true;

        if (is_array($name)) {
            if (!isset($name['name'])) {
                throw new InvalidElementException(sprintf(
                    'Elements defined dynamically in parent or children must define a name. [%s]',
                    implode(' -> ', $circular)
                ));
            }

            $current = $name;

            $name = $current['name'];
            unset($current['name']);

            $getCurrent = false;
        }

        $circular[] = $name;

        if ($getCurrent) {
            $current = $this->getCurrentElement($name);
        }

        if (isset($current['class']) && !class_exists($current['class'])) {
            throw new InvalidElementException(sprintf('The element "%s" define a class which doesn\'t exist.', $name));
        }

        foreach ($this->checks as $check) {
            if (isset($current[$check])) {
                $currentCheck = (array)$current[$check];

                if (in_array($name, $currentCheck)) {
                    throw new InvalidElementException(sprintf(
                        'Element "%s" cannot define himself as %s.',
                        $name,
                        $check
                    ));
                }

                foreach ($currentCheck as $cc) {
                    if (!is_array($cc) && !$this->exists($cc)) {
                        throw new UndefinedElementException(sprintf(
                            'The element "%s" defines a %s "%s" wich doesn\'t exist.',
                            $name,
                            $check,
                            $cc
                        ));
                    }

                    if (!is_array($cc) && in_array($cc, $circular)) {
                        $circular[] = $cc;

                        throw new InvalidElementException(sprintf(
                            'Element "%s" cannot define "%s" as %s. It\'s a circular reference. [%s]',
                            $name,
                            $cc,
                            $check,
                            implode(' -> ', $circular)
                        ));
                    }

                    $this->validBranch($cc, $circular);
                }
            }
        }
    }

    /**
     * Get the current element representation.
     *
     * @param string $name The element name
     *
     * @return array
     */
    private function getCurrentElement($name)
    {
        return $this->map[lcfirst($name)];
    }

    /**
     * Replace the parameters of the element.
     *
     * @param array $element    The element with the parameters to replace
     * @param array $parameters The array of parameters values
     *
     * @return array
     */
    private function replaceParameters(array $element, array $parameters)
    {
        foreach ($element as $key => $value) {
            if (is_array($value)) {
                $element[$key] = $this->replaceParameters($value, $parameters);
            }

            if (is_string($value)) {
                foreach ($parameters as $parameter => $replace) {
                    $value = str_replace('%' . $parameter . '%', $replace, $value);
                }

                $element[$key] = $value;
            }
        }

        return $element;
    }

    /**
     * Extend element from another one.
     *
     * @param array $extend  The array of the element to extend
     * @param array $current The current element which extends
     *
     * @return array
     */
    private function extendElement($extend, $current)
    {
        $current['class'] = $extend['class'];

        $current['attr'] = $this->extendAttributes($extend['attr'], $current['attr']);

        return $current;
    }

    /**
     * Extend attributes from another element.
     *
     * @param array $from The array of attributes to extend
     * @param array $to   The array of attributes which extends
     *
     * @return array
     */
    private function extendAttributes(array $from, array $to)
    {
        foreach ($from as $key => $value) {
            if (in_array($key, $this->mergeableAttributes) && isset($to[$key])) {
                $to[$key] = array_merge((array)$to[$key], (array)$value);
            } elseif (!isset($to[$key])) {
                $to[$key] = $value;
            } elseif (is_array($value)) {
                $to[$key] = $this->extendAttributes($value, $to[$key]);
            }
        }

        return $to;
    }
}
