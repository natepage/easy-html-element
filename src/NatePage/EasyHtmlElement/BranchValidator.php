<?php

namespace NatePage\EasyHtmlElement;

use NatePage\EasyHtmlElement\Exception\InvalidElementException;

class BranchValidator implements BranchValidatorInterface
{
    /** @var HtmlElementInterface */
    private $htmlElement;

    /**
     * @var array The options to check to valid a branch. The bool determine if the option can
     *            define more than one value. True = unique value, False = multiple values
     */
    private $checks = array(
        'parent' => true,
        'extends' => false,
        'children' => false
    );

    public function __construct(HtmlElementInterface $htmlElement)
    {
        $this->htmlElement = $htmlElement;
    }

    /**
     * {@inheritdoc}
     */
    public function validateBranch($name, array $circular = array())
    {
        $current = $this->htmlElement->getCurrentElement($name);

        $circular[] = $current['name'];

        $this->validateClass($current);

        foreach ($this->checks as $check => $unique) {
            if (isset($current[$check])) {
                $this->validateDefineHimself($current['name'], $current[$check], $check);

                if ($unique) {
                    $this->validateCircularReferences($current['name'], $current[$check], $check, $circular);
                    $this->validateBranch($current[$check], $circular);
                } else {
                    foreach ((array) $current[$check] as $cc) {
                        $this->validateCircularReferences($current['name'], $cc, $check, $circular);
                        $this->validateBranch($cc, $circular);
                    }
                }
            }
        }
    }

    /**
     * Validate the current element class.
     *
     * @param array $current The current element
     *
     * @throws InvalidElementException If the current element defines a class which doesn't exist
     */
    private function validateClass(array $current)
    {
        if (isset($current['class']) && !class_exists($current['class'])) {
            throw new InvalidElementException(sprintf(
                'The element "%s" define a class which doesn\'t exist.',
                $current['name']
            ));
        }
    }

    /**
     * Validate himself references.
     *
     * @param string $name         The current element name
     * @param array  $currentCheck The current check context
     * @param string $check        The current check name
     *
     * @throws InvalidElementException If the current element defines himself as parent, children or extends
     */
    private function validateDefineHimself(string $name, $currentCheck, string $check)
    {
        if (in_array($name, (array) $currentCheck)) {
            throw new InvalidElementException(sprintf(
                'Element "%s" cannot define himself as %s.',
                $name,
                $check
            ));
        }
    }

    /**
     * Validate circular references.
     *
     * @param string       $name         The current element name
     * @param string|array $currentCheck The current check context
     * @param string       $check        The current check name
     * @param array        $circular     The names of the previous elements called
     *
     * @throws InvalidElementException If the current element defines a parent, child or extends which creates circular
     *                                 reference
     */
    private function validateCircularReferences(string $name, $currentCheck, string $check, array $circular)
    {
        if (!is_array($currentCheck) && in_array($currentCheck, $circular)) {
            $circular[] = $currentCheck;

            throw new InvalidElementException(sprintf(
                'Element "%s" cannot define "%s" as %s. It\'s a circular reference. [%s]',
                $name,
                $currentCheck,
                $check,
                implode(' -> ', $circular)
            ));
        }
    }
}
