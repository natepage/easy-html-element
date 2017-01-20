<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Getting started

The purpose of **EasyHtmlElement** is to centralise the HTML elements definition in a _map_ (a simple PHP array) to make you able to use or reuse it easily and where you want in your HTML code.

You can define dependencies between your elements, any attribute you want, any type of element, use parameters to make your elements dynamics. So let us to show you all possibilities!

####Map structure
The map is the PHP array where you will define all your HTML elements.

``` php
$map = array(
    'elementName' => array(/* element definition */),
    'anotherElementName' => array(/* element definition */),
    
    //Any elements you want... 
);
```

You will use the _elementName_ key to generate the HTML code later so it must be **unique** in the map.

####Element definition
The default element representation it's the next:

``` php
$map = array(
    'elementName' => array(
        'class' => NatePage\EasyHtmlElement\Element::class,
        'type' => null,
        'text' => null,
        'attr' => array(),
        'parent' => null,
        'children' => array(),
        'extends' => array()
    )
);
```

* **(string) class:** EasyHtmlElement use the map to generate PHP objects, by default generated objects use the _NatePage\EasyHtmlElement\Element::class_. If you want to use your own class to customize elements logic, read [customization](customization.md).

* **(string | null) type:** The type of the generated HTML tag. By example, `<div></div>` is a HTML tag with a `div` type. By default it's null so the generated value will be a simple string, define you own type with `'type' => 'div'`.

* **(string | null) text:** The element content. You can put whatever you want as string value, by default HTML escaping strategy is applied on it to secure the generated code. More informations from [escaping](escaping.md).

* **(array) attr:** The element attributes. It works like `array('attrName' => 'value')`. You can define any attributes you want and rendering is recursive so you define an attribute value as an array if you want. By default HTML attributes escaping strategy is applied on it to secure the generated code. More informations from [attributes](attributes.md) or [escaping](escaping.md).

* **(string | array | null) parent:** The element parent which will frame the current element. By example a `span` element with a `div` parent will generate `<div><span></span></div>`. It could be the name of another defined element in the map. It could be an array which defines a dynamic element. By default is null, you can keep it if you don't want to define a parent for the current element. More informations from [parent](parent.md).

* **(array) children:** The element children. It defines all the elements which will be framed by the current element. It could contains the names of another defined elements in the map or array to define children dynamically. More informations from [children](children.md).

* **(array) extends:** It defines all the elements which the current element extends. When an element extends another one, all options above not defined are overridden by the extended elements. Attributes _class_ and _style_ are defined as mergeable so their values or not overridden but merged, so the current element will have its own values + extended elements values. More informations from [extends](extends.md).

####Usage
Everybody has a nice HTML elements map? Nice, now how to generate the HTML code?

``` php
$map = array(/* You wonderful map */);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

$myElement = $htmlElement->load('myElement');

echo $myElement->render();
```

Or maybe you want something simplier? EasyHtmlElement uses the magic methods `__call()` and `__toString()` to allow you to do something like:

``` php
$map = array(/* You wonderful map */);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

$myElement = $htmlElement->myElement();

echo $myElement;
```

That's it! Cool, isn't it?
