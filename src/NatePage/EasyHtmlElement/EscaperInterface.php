<?php

namespace NatePage\EasyHtmlElement;

interface EscaperInterface
{
    /**
     * Apply escaping strategies to an element.
     *
     * @param ElementInterface $element The element to escape
     *
     * @return ElementInterface
     */
    public function escape(ElementInterface $element);

    /**
     * Apply escaping strategies on element attributes.
     *
     * @param array $attributes The attributes array to escape
     *
     * @return array
     */
    public function escapeAttributes(array $attributes);

    /**
     * Apply url escaping strategy on an url parameter.
     *
     * @param string $parameter The parameter to escape
     *
     * @return string
     */
    public function escapeUrlParameter($parameter);

    /**
     * Get the urls attributes.
     *
     * @return array
     */
    public function getUrlsAttributes();

    /**
     * Determine if html escaping strategy is applied.
     *
     * @param bool $escapeHtml
     */
    public function setEscapeHtml($escapeHtml = true);

    /**
     * Check if html escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeHtml();

    /**
     * Determine if html attributes escaping strategy is applied.
     *
     * @param bool $escapeHtmlAttr
     */
    public function setEscapeHtmlAttr($escapeHtmlAttr = true);

    /**
     * Check if html attributes escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeHtmlAttr();

    /**
     * Determine if css escaping strategy is applied.
     *
     * @param bool $escapeCss
     */
    public function setEscapeCss($escapeCss = true);

    /**
     * Check if css escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeCss();

    /**
     * Determine if javascript escaping strategy is applied.
     *
     * @param bool $escapeJs
     */
    public function setEscapeJs($escapeJs = true);

    /**
     * Check if javascript escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeJs();

    /**
     * Determine if urls escaping strategy is applied.
     *
     * @param bool $escapeUrl
     */
    public function setEscapeUrl($escapeUrl = true);

    /**
     * Check if urls escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeUrl();
}
