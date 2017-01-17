<?php

namespace NatePage\EasyHtmlElement;

interface BranchValidatorInterface
{
    /**
     * Valid the current map branch.
     *
     * @param string $name     The current element name
     * @param array  $circular The array of elements names called in the current branch of map
     */
    public function validateBranch($name, array $circular = array());
}
