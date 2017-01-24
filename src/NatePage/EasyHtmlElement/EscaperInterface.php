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
    public function escape(ElementInterface $element): ElementInterface;

    /**
     * Apply escaping strategies on element attributes.
     *
     * @param array $attributes The attributes array to escape
     *
     * @return array
     */
    public function escapeAttributes(array $attributes): array;

    /**
     * Apply url escaping strategy on an url parameter.
     *
     * @param string $parameter The parameter to escape
     *
     * @return string
     */
    public function escapeUrlParameter(string $parameter): string;

    /**
     * Get the urls attributes.
     *
     * @return array
     */
    public function getUrlsAttributes(): array;

    /**
     * Determine if html escaping strategy is applied.
     *
     * @param bool $escapeHtml
     *
     * @return EscaperInterface
     */
    public function setEscapeHtml(bool $escapeHtml = true): self;

    /**
     * Check if html escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeHtml(): bool;

    /**
     * Determine if html attributes escaping strategy is applied.
     *
     * @param bool $escapeHtmlAttr
     *
     * @return EscaperInterface
     */
    public function setEscapeHtmlAttr(bool $escapeHtmlAttr = true): self;

    /**
     * Check if html attributes escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeHtmlAttr(): bool;

    /**
     * Determine if css escaping strategy is applied.
     *
     * @param bool $escapeCss
     *
     * @return EscaperInterface
     */
    public function setEscapeCss(bool $escapeCss = true): self;

    /**
     * Check if css escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeCss(): bool;

    /**
     * Determine if javascript escaping strategy is applied.
     *
     * @param bool $escapeJs
     *
     * @return EscaperInterface
     */
    public function setEscapeJs(bool $escapeJs = true): self;

    /**
     * Check if javascript escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeJs(): bool;

    /**
     * Determine if urls escaping strategy is applied.
     *
     * @param bool $escapeUrl
     *
     * @return EscaperInterface
     */
    public function setEscapeUrl(bool $escapeUrl = true): self;

    /**
     * Check if urls escaping strategy is applied.
     *
     * @return bool
     */
    public function isEscapeUrl(): bool;
}
