<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Extends

An element can extends one or multiple others elements. It allows you to define base elements and extend their options to create new elements whitout typing code anymore.

For each default options if the current doesn't define a value it will take the extended element value. Except for `attr` and `children` which will be merged.

If an element extends another which extends another which extends... etc... All the tree will be extended.

####Simple extends

```php
$map = array(
    'btn' => array(
        'type' => 'button',
        'text' => 'A button'
    ),
    
    'btnBlue' => array(
        'extends' => 'btn',
        'attr' => array(
            'class' => 'btn-blue'
        )
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

echo $htmlElement->btnBlue();

/**
 * <button class="btn-blue">A button</button>
 */
```

####Multiple extends

```php
$map = array(
    'btn' => array(
        'type' => 'button',
        'text' => 'A button'
    ),
    
    'btnRound' => array(
        'extends' => 'btn',
        'attr' => array(
            'class' => 'btn-round'
        )
    ),
    
    'btnBlue' => array(
        'extends' => 'btn',
        'attr' => array(
            'class' => 'btn-blue'
        )
    ),
    
    'btnBlueRound' => array(
        'extends' => array('btnBlue', 'btnRound')
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

echo $htmlElement->btnBlueRound();

/**
 * <button class="btn-blue btn-round">A button</button>
 */
```
