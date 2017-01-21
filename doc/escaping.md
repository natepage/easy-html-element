<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Escaping

To defend the generated HTML code from XSS vulnerabilities EasyHtmlElement escape the output by default. It uses [zendframework/zend-escaper](https://github.com/zendframework/zend-escaper) but if you want to use another escaper you can, more informations from [customization](customization.md).

Escaping strategies are applied to:

* HTML content
* HTML attributes
* Javascript
* CSS
* URLs

You can find more informations from the excellent [zend-escaper documentation](https://zendframework.github.io/zend-escaper/intro/).

####Disable strategies

By default all escaping strategies are enabled but if you want to disable it you can but you actively recommend you to make sure your code is safe.

To disable one or multiple escaping strategies you can do it like:

```php
$htmlElement = new NatePage\EasyHtmlElement\HtmlElement();

$htmlElement->getEscaper()
            ->setEscapehtml(false)      //HTML content
            ->setEscapehtmlAttr(false)  //HTML attributes
            ->setEscapeJs(false)        //Javascript
            ->setEscapeCss(false)       //CSS
            ->setEscapeUrl(false);      //URLs
```

####Javascript and CSS

Javascript and CSS escaping strategies are applied when element is respectively `script` and `style`.

####URLs

URLs escaping strategy is applied on [parameters](parameters.md) when they are defined in `href` or `src` [attributes](attributes.md).
