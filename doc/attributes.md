<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Attributes

Elements attributes are defined under the `attr` key, it uses an array where keys are attributes names and values are attributes values:

```php
$map = array(
    'element' => array(
        //...
        'attr' => array(
            'id' => 'element-id',
            'class' => 'first-class second-class',
            'style' => 'font-size: 16px; text-align: center;',
            //...
            'onclick' => 'alert(\'EasyHtmlElement!\');'
        )
    )
);
```

You can define any attributes you want even your own.

Attributes can be arrays, EasyHtmlElement will automatically render it as formatted string:

```php
$map = array(
    'element' => array(
        //...
        'attr' => array(
            'id' => 'element-id',
            'class' => array(
                'first-class', 
                'second-class'
            ),
            'style' => array(
                'font-size: 16px', 
                'text-align: center'
            ),
            //...
            'onclick' => 'alert(\'EasyHtmlElement!\');'
        )
    )
);

//class -> 'first-class second-class'
//style -> 'font-size: 16px; text-align: center;'
```

You don't need to add the `;` at the styles end.
