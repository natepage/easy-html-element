<?php

namespace NatePage\EasyHtmlElement;

use Zend\Escaper\Escaper as BaseEscaper;

class Escaper extends BaseEscaper implements EscaperInterface
{
    /** @var array The special escaping types */
    private $specialEscapingTypes = array('script', 'style');

    /** @var array The urls attributes */
    private $urlsAttributes = array('href', 'src');

    /** @var bool Determine if html is escaped or not */
    private $escapeHtml = true;

    /** @var bool Determine if html attributes are escaped or not */
    private $escapeHtmlAttr = true;

    /** @var bool Determine if javascript is escaped or not */
    private $escapeJs = true;

    /** @var bool Determine if css is escaped or not */
    private $escapeCss = true;

    /** @var bool Determine if urls parameters are escaped or not */
    private $escapeUrl = true;

    /**
     * {@inheritdoc}
     */
    public function escapeAttributes(array $attributes): array
    {
        if ($this->escapeHtmlAttr || $this->escapeUrl) {
            foreach ($attributes as $attr => $value) {
                if (is_array($value)) {
                    $value = $this->escapeAttributes($value);
                } elseif (!in_array($attr, $this->urlsAttributes)) {
                    if ($this->escapeHtmlAttr) {
                        $value = $this->escapeHtmlAttr($value);
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
    public function escape(ElementInterface $element): ElementInterface
    {
        if ($this->escapeHtml && !in_array($element->getType(), $this->specialEscapingTypes)) {
            $element->setText($this->escapeHtml($element->getText()));
        }

        $element->setAttributes($this->escapeAttributes($element->getAttributes()));

        if ($this->escapeJs && 'script' == $element->getType()) {
            $element->setText($this->escapeJs($element->getText()));
        }

        if ($this->escapeCss && 'style' == $element->getType()) {
            $element->setText($this->escapeCss($element->getText()));
        }

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function escapeUrlParameter(string $parameter): string
    {
        return $this->escapeUrl($parameter);
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeHtml(): bool
    {
        return $this->escapeHtml;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeHtml(bool $escapeHtml = true): EscaperInterface
    {
        $this->escapeHtml = $escapeHtml;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeHtmlAttr(): bool
    {
        return $this->escapeHtmlAttr;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeHtmlAttr(bool $escapeHtmlAttr = true): EscaperInterface
    {
        $this->escapeHtmlAttr = $escapeHtmlAttr;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeJs(): bool
    {
        return $this->escapeJs;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeJs(bool $escapeJs = true): EscaperInterface
    {
        $this->escapeJs = $escapeJs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeCss(): bool
    {
        return $this->escapeCss;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeCss(bool $escapeCss = true): EscaperInterface
    {
        $this->escapeCss = $escapeCss;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEscapeUrl(): bool
    {
        return $this->escapeUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeUrl(bool $escapeUrl = true): EscaperInterface
    {
        $this->escapeUrl = $escapeUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlsAttributes(): array
    {
        return $this->urlsAttributes;
    }
}
