<h1 align="center">EasyHtmlElement</h1>

<p align="center">
    <a href="https://travis-ci.org/natepage/easy-html-element"><img src="https://travis-ci.org/natepage/easy-html-element.svg?branch=master" alt="Build Status"></a>
    <a href="https://insight.sensiolabs.com/projects/1ca37d08-6889-4280-aa4c-5739bf2be48a"><img src="https://img.shields.io/sensiolabs/i/1ca37d08-6889-4280-aa4c-5739bf2be48a.svg" alt="SensioLabs Insight"></a>
    <a href="https://scrutinizer-ci.com/g/natepage/easy-html-element"><img src="https://img.shields.io/scrutinizer/g/natepage/easy-html-element.svg" alt="Quality Score"></a>
</p>

<p align="center">An easy way to create simple or complex html elements in PHP.</p>

---

**EasyHtmlElement** is an open source software library which allows you to define a map of your html elements and use them simply in your html code. You can define simple elements like links, buttons, lists, images or use custom types. But the power of this library is to define complex html structures with elements which has attributes, parent, children or extends others elements attributes. And after your elements map made, you can do it with only one PHP method!

##Installation
####Composer
Find all informations about Composer from `https://getcomposer.org/`

Run the following command:
```
$ composer require natepage/easy-html-element
```

####Repository
You can directly clone the repository but you'll have to install the dependencies manually.

##Usage
Did you already use an array in PHP? Yes? Nice! With EasyHtmlElement just have to create a simple PHP array and we manage the rest! We'll call this array _map_ for all the next examples.

So _map_ is a simple key/value array where you will define your html elements like:

* key (string): The element name you'll use to generate it in your code
* value (array): All the element informations

####Simple example
``` php
$map = array(
    'myDiv' => array(
        'type' => 'div',
        'text' => 'Simple Div Example'
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement();
$div = $htmlElement->load('myDiv');

echo $div; 

/**
 * <div>
 *      Simple Div Example
 * </div>
 */
```
In the example above we just display a simple div and yes I agree you don't really need a library to do that but it's to show the logic so if you want to see the real power of EasyHtmlElement keep reading!

You can see you don't need to call a specific method to render elements, we use the magic method ___toString()_ to make your life easier! :)

####More Complex Example (Bootstrap Panel)
``` php
$map = array(
    //Base div
    'div' => array(
        'type' => 'div'
    ),
    //Base panel structure
    'panel' => array(
        'extends' => array('div'),
        'attr' => array('class' => 'panel'),
        'children' => array(
            'panelHeading',
            'panelBody',
            'panelFooter'
        )
    ),
    //Panel heading
    'panelHeading' => array(
        'extends' => array('div'),
        'attr' => array('class' => 'panel-heading'),
        'children' => array(
            array(
                'name' => 'panelHeadingTitle',
                'type' => 'h3',
                'attr' => array('class' => 'panel-title'),
                'text' => '%panel_title%'
            )
        )
    ),
    //Panel body
    'panelBody' => array(
        'extends' => array('div'),
        'attr' => array('class' => 'panel-body'),
        'text' => '%panel_body%'
    ),
    //Panel footer
    'panelFooter' => array(
        'extends' => array('div'),
        'attr' => array('class' => 'panel-footer'),
        'text' => '%panel_footer%'
    ),
    //Primary panel structure
    'panelPrimary' => array(
        'extends' => array('panel'),
        'attr' => array('class' => 'panel-primary')
    )
);

$htmlElement = new \NatePage\EasyHtmlElement\HtmlElement($map);
$panelPrimary = $htmlElement->load('panelPrimary', array(
    'panel_title' => 'My Panel Title',
    'panel_body' => 'My Panel Body',
    'panel_footer' => 'My Panel Footer'
));

echo $panelPrimary;

/**
 * <div class="panel-primary panel">
 *      <div class="panel-heading">
 *          <h3 class="panel-title">My Panel Title</h3>
 *      </div>
 *      <div class="panel-body">
 *          My Panel Body
 *      </div>
 *      <div class="panel-footer">
 *          My Panel Footer
 *      </div>
 * </div>
 */
```
Here we have:
* All the panel components extend the _Base div_ element to get the _div_ type
* Base panel structure define _children_ to make its content
* All elements define their own attributes with _attr_
* Panel heading defines a dynamic child directly in its children array
* Primary panel structure extends all the Base panel structure and add a css class
* Some parameters with the _%parameter%_ syntax which allows you to define dynamic content

A complex and dynamic html structure in just on method, that's what EasyHtmlElement promised you!

##Documentation
Does it make you want to learn more about the EasyHtmlElement power?

Read the [documentation](doc/index.md).

##Dependencies
* [airmanbzh/php-html-generator](https://github.com/Airmanbzh/php-html-generator) to render html elements
* [zendframework/zend-escaper](https://github.com/zendframework/zend-escaper) to secure the generated html code with escaping strategies

We actively recommend you to use [symfony/yaml](http://symfony.com/doc/current/components/yaml.html) to make your map building easier.

##Customization
If you need to customize the code logic, EasyHtmlElement one more time makes it easier for you with somes interfaces. All informations in the [documentation](doc/customization.md).

##Contributing
Please don't hesitate to open an issues or a pull request if you find something wrong in the code, a typo in the documentation, if you have an evolution idea in mind or if you just want to say hello! :)

##Versioning
EasyHtmlElement is maintained under the Semantic Versioning guidelines so releases will be numbered with the following format:
```
MAJOR.MINOR.PATCH
```
For more informations on SemVer, please visit `http://semver.org`
