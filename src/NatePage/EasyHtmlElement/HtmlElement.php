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

    /** @var BranchValidatorInterface */
    private $branchValidator;

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

    /** @var array The mergeable attributes */
    private $mergeableAttributes = array('class', 'style');

    /**
     * HtmlElement constructor.
     *
     * @param array                         $map             The elements map
     * @param BranchValidatorInterface|null $branchValidator The branch validator
     * @param EscaperInterface|null         $escaper         The escaper, by default ZendFramework/Escaper is used
     * @param string                        $encoding        The encoding used for escaping, by default utf-8 is used
     */
    public function __construct(
        array $map = array(),
        BranchValidatorInterface $branchValidator = null,
        EscaperInterface $escaper = null,
        $encoding = 'utf-8')
    {
        $this->map = $map;
        $this->branchValidator = null !== $branchValidator ? $branchValidator : new BranchValidator($this);
        $this->escaper = null !== $escaper ? $escaper : new Escaper($encoding);
    }

    /**
     * Load element on dynamic calls.
     *
     * @param string $name      The element name
     * @param array  $arguments The arguments array to set:
     *                          [0] = text (string|null)
     *                          [1] = attributes (array)
     *                          [2] = parameters (array)
     *                          [3] = extras (array)
     *                          [4] = children (array)
     *
     * @return ElementInterface
     *
     * @throws InvalidArgumentsNumberException If the arguments length is more than 3
     */
    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);

        return $this->load(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * {@inheritdoc}
     */
    public function setMap(array $map): HtmlElementInterface
    {
        $this->map = $map;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addManyToMap(array $elements): HtmlElementInterface
    {
        foreach ($elements as $name => $element) {
            $this->addOneToMap($name, $element);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addOneToMap(string $name, array $element): HtmlElementInterface
    {
        $this->map[$name] = $element;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBranchValidator(): BranchValidatorInterface
    {
        return $this->branchValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function setBranchValidator(BranchValidatorInterface $branchValidator): HtmlElementInterface
    {
        $this->branchValidator = $branchValidator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEscaper(): EscaperInterface
    {
        return $this->escaper;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscaper(EscaperInterface $escaper): HtmlElementInterface
    {
        $this->escaper = $escaper;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load(
        $name,
        $text = null,
        array $attributes = array(),
        array $parameters = array(),
        array $extras = array(),
        array $children = array()
    ): ElementInterface
    {
        $element = $this->getInstance($name, $text, $extras, $parameters, true);

        $element->addAttributes($this->escaper->escapeAttributes($attributes));

        foreach ($children as $child) {
            $element->addChild($this->escaper->escape($child->getRoot()));
        }

        return $element;
    }

    /**
     * Get the element instance.
     *
     * @param string|array $name       The element name
     * @param string|null  $text       The element text
     * @param array        $extras     The element extras
     * @param array        $parameters The parameters to replace in element
     * @param bool         $mainCall   Determine if it's the main(first) call of the method
     *
     * @return ElementInterface
     *
     * @throws InvalidElementException If the current instance doesn't implement ElementInterface
     */
    private function getInstance(
        $name, $text,
        array $extras,
        array $parameters,
        bool $mainCall = false
    ): ElementInterface
    {
        $element = $this->resolveElement($name, $parameters, $mainCall);

        $class = $element['class'];
        $type = $element['type'];
        $text = $text !== null ? $text : $element['text'];
        $attributes = $element['attr'];

        $children = array();
        foreach ((array) $element['children'] as $child) {
            $children[] = $this->getInstance($child, null, array(), $parameters);
        }

        $instance = new $class($type, $text, $attributes, $extras, $children);

        if (!$instance instanceof ElementInterface) {
            throw new InvalidElementException(sprintf(
                'The element "%s" does not implement the %s',
                get_class($instance),
                ElementInterface::class
            ));
        }

        if (null !== $element['parent']) {
            $parent = $this->getInstance($element['parent'], null, array(), $parameters);

            $parent->addChild($instance->getRoot());
        }

        return $this->escaper->escape($instance);
    }

    /**
     * Get the resolved element representation.
     *
     * @param string|array $name       The current element name
     * @param array        $parameters The parameters to replace in element
     * @param bool         $mainCall   Determine if it's the main(first) call of the method
     *
     * @return array
     */
    private function resolveElement($name, array $parameters, bool $mainCall = false): array
    {
        $current = $this->getCurrentElement($name);

        $name = $current['name'];

        if ($this->alreadyResolved($name)) {
            return $this->replaceParameters($this->resolved[$name], $parameters);
        }

        if ($mainCall) {
            $this->branchValidator->validateBranch($name);
        }

        foreach ($this->defaults as $default => $value) {
            if (!isset($current[$default])) {
                $current[$default] = $value;
            }
        }

        foreach ((array) $current['extends'] as $extend) {
            $extend = $this->resolveElement($extend, $parameters);
            $current = $this->extendElement($extend, $current);
        }

        $this->resolved[$name] = $current;

        $current = $this->replaceParameters($current, $parameters);

        return $current;
    }

    /**
     * Check if an element has been already resolved.
     *
     * @param string $name
     *
     * @return bool
     */
    private function alreadyResolved(string $name): bool
    {
        return array_key_exists($name, $this->resolved);
    }

    /**
     * {@inheritdoc}
     */
    public function exists(string $name): bool
    {
        return array_key_exists(lcfirst($name), $this->map);
    }

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
    public function getCurrentElement($name): array
    {
        if (is_array($name)) {
            if (!isset($name['name'])) {
                throw new InvalidElementException(sprintf(
                    'Elements defined dynamically in parent or children must define a name.'
                ));
            }

            return $name;
        }

        if (!$this->exists($name)) {
            throw new UndefinedElementException(sprintf('The element with name "%s" does not exist.', $name));
        }

        $current = $this->map[lcfirst($name)];
        $current['name'] = $name;

        return $current;
    }

    /**
     * Replace parameters in text and attr.
     *
     * @param array $element    The element with the parameters to replace
     * @param array $parameters The array of parameters values
     *
     * @return array
     */
    private function replaceParameters(array $element, array $parameters): array
    {
        foreach ($parameters as $parameter => $replace) {
            $element['text'] = str_replace('%'.$parameter.'%', $replace, (string) $element['text']);
        }

        $element['attr'] = $this->replaceParametersInAttributes($element['attr'], $parameters);

        return $element;
    }

    /**
     * Replace parameters in attr.
     *
     * @param array $attributes The attributes
     * @param array $parameters The parameters
     *
     * @return array
     */
    private function replaceParametersInAttributes(array $attributes, array $parameters): array
    {
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $attributes[$key] = $this->replaceParametersInAttributes($value, $parameters);
            }

            foreach ($parameters as $parameter => $replace) {
                if (in_array($key, $this->escaper->getUrlsAttributes()) && $this->escaper->isEscapeUrl()) {
                    $replace = $this->escaper->escapeUrlParameter($replace);
                }

                $value = str_replace('%'.$parameter.'%', $replace, (string) $value);
            }

            $attributes[$key] = $value;
        }

        return $attributes;
    }

    /**
     * Extend element from another one.
     *
     * @param array $extend  The array of the element to extend
     * @param array $current The current element which extends
     *
     * @return array
     */
    private function extendElement(array $extend, array $current): array
    {
        foreach ($this->defaults as $default => $value) {
            if (!in_array($default, array('attr', 'children')) && $current[$default] === $value) {
                $current[$default] = $extend[$default];
            }
        }

        $current['attr'] = $this->extendAttributes($extend['attr'], $current['attr']);

        foreach ($extend['children'] as $child) {
            $current['children'][] = $child;
        }

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
    private function extendAttributes(array $from, array $to): array
    {
        foreach ($from as $key => $value) {
            if (in_array($key, $this->mergeableAttributes) && isset($to[$key])) {
                $to[$key] = $this->extendMergeableAttributes($value, $to[$key], $key);
            } elseif (!isset($to[$key])) {
                $to[$key] = $value;
            } elseif (is_array($value)) {
                $to[$key] = $this->extendAttributes($value, $to[$key]);
            }
        }

        return $to;
    }

    /**
     * Extend mergeable attributes from another element.
     *
     * @param string|array $from The attribute to extend
     * @param string|array $to   The attribute which extends
     * @param string       $attr The attribute name
     *
     * @return string
     */
    private function extendMergeableAttributes($from, $to, string $attr): string
    {
        $value = array_merge((array) $to, (array) $from);

        switch ($attr) {
            case 'class':
                return implode(' ', $value);
            case 'style':
                return implode('; ', $value);
        }
    }
}
