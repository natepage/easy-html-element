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
    public function escapeAttributes(array $attributes)
    {
        if ($this->escapeHtmlAttr || $this->escapeUrl) {
            foreach ($attributes as $attr => $value) {
                if (!in_array($attr, $this->urlsAttributes)) {
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
    public function escape(ElementInterface $element)
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
    public function escapeUrlParameter($parameter)
    {
        return $this->escapeUrl($parameter);
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
    public function getUrlsAttributes()
    {
        return $this->urlsAttributes;
    }
}
