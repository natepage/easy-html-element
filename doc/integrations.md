<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Integrations

####Symfony

EasyHtmlElement provides a Symfony bundle that allow you to use it as a service. Register it in your `AppKernel.php`:

```php
# app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        //...
        $bundles = array(
            new NatePage\EasyHtmlElement\Bridge\Symfony\EasyHtmlElementBundle(),
        );
        //...
    }
    //...
}
```

You can define your `map` and customize default options in `app/config.yml` (or in your custom yml file as an import):

```yaml
easy_html_element:
    encoding:         utf-8
    escaper:          NatePage\EasyHtmlElement\Escaper
    branch_validator: NatePage\EasyHtmlElement\BranchValidator
    escaping:
        html:         true
        html_attr:    true
        css:          true
        js:           true
        url:          true
    map:
        myDiv:
            type: div
            text: My div with Symfony
```

You can use the `easy_html_element` service in your controller:

```php
$myDiv = $this->get('easy_html_element')->load('MyDiv');
```

####Twig

The symfony integration provides a Twig function to use EasyHtmlElement in your templates:

```twig
{{ htmlElement('myDiv') }}
```

If you use Twig outside of Symfony you need to add the EasyHtmlElementExtension to your environment:

```php
use NatePage\EasyHtmlElement\Bridge\Twig\EasyHtmlElementExtension;
use NatePage\EasyHtmlElement\HtmlElement;

$twig = new Twig_Environnement($loader);
$twig->addExtension(new EasyHtmlElementExtension(new HtmlElement($map));
```

####Laravel

EasyHtmlElement also provides a service provider and a facade to integrate into Laravel. In `config/app.php`,  add the next code:

```php
return [
    //...
    'providers' => [
        //...
        NatePage\EasyHtmlElement\Bridge\Laravel\EasyHtmlElementServiceProvider::class,
    ],
    //...
    'aliases' => [
        'HtmlElement' => NatePage\EasyHtmlElement\Bridge\Laravel\EasyHtmlElementFacade::class,
    ],
];
```

To define your `map` you first need to publish the package configuration file with the command:

```
$ php artisan vendor:publish
```

Then you can define your `map` in `config/easy_html_element.php`:

```php
return [
    'map' => [
        'myDiv' => [
            'type' => 'div',
            'text' => 'My div with Laravel'
        ]
    ]
];
```

Finally you can use it in your controllers and/or blade templates:

```php
$myDiv = HtmlElement::load('myDiv');
```
