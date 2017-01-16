<?php

namespace NatePage\EasyHtmlElement;

interface EscaperInterface
{
    /**
     * Escape a string for an HTML body context.
     *
     * @param string $string The string to escape
     *
     * @return string
     */
    public function escapeHtml($string);

    /**
     * Escape a string for an HTML attribute context.
     *
     * @param string $string The string to escape
     *
     * @return string
     */
    public function escapeHtmlAttr($string);

    /**
     * Escape a string for a Javascript context.
     *
     * @param string $string The string to escape
     *
     * @return string
     */
    public function escapeJs($string);

    /**
     * Escape a string for a CSS context.
     *
     * @param string $string The string to escape
     *
     * @return string
     */
    public function escapeCss($string);

    /**
     * Escape a string for a URI or URI parameter context
     *
     * @param string $string The string to escape
     *
     * @return string
     */
    public function escapeUrl($string);
}
