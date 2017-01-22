<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Parameters

EasyHtmlElement allows you to define parameters in your elements to make it dynamic. Parameters will be replace by given values. You can define parameters in `text` and `attr` and you do it with this syntax `%parameter%`.

Parameters values are the 2nd load method argument (or the 1st if you call it dynamically with the magic method `__call()`). It's an array where keys are parameters name and values are parameters values.

```php
$map = array(
    'title' => array(
        'type' => 'h1',
        'text' => '%titleText%'
    );
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

echo $htmlElement->title(array('titleText' => 'My title'));

/**
 * <h1>My title</h1>
 */
```

####Text and Attributes

You can define parameters wherever you want like to define a css class dynamically:

```php
$map = array(
    'title' => array(
        'type' => 'h1',
        'text' => '%titleText%',
        'attr' => array(
            'class' => 'title title-%titleClass%'
        )
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

echo $htmlElement->title(array('titleText' => 'My title', 'titleClass' => 'success'));

/**
 * <h1 class="title title-success">My title</h1>
 */
```
