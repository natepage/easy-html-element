<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Dynamic elements

Each element allows you to define `parent`, `children` and `extends` where you can refer to a defined element by its name. But you also define new elements dynamically if you pass an array as value. A dynamic element has the same options than each element but it **has** to define a `name`.

A dynamic element works like each element so it can refer to an defined element in map or define dynamic elements himself.

####Dynamic children
 
```php
$map = array(
     'table' => array(
         'type' => 'table',
         'children' => array(
             array(                             //row1 dynamically
                'name' => 'row1',               //
                'type' => 'tr',                 //
                'children' => array(            //
                    array(                      //cellRow1 dynamically
                        'name' => 'cellRow1',   //
                        'type' => 'td',         //
                        'text' => 'Cell row 1'  //
                    )                           //
                )                               //
             ),                                 //
             'row2'
         )
     ),
     'row2' => array(
         'type' => 'tr',
         'children' => array(
             'cellRow2'
         )
     ),
     'cellRow2' => array(
         'type' => 'td',
         'text' => 'Cell row 1'
     ),
 );
```

####Dynamic parent

```php
$map = array(
    'cell' => array(
        'type' => 'td',
        'text' => 'My cell',
        'parent' => array(          //row dynamically
            'name' => 'row',        //
            'type' => 'tr',         //
            'parent' => array(      //table dynamically
                'name' => 'table',  //
                'type' => 'table'   //
            )
        )
    )
);
```

####Dynamic extends

You can define a dynamic element in `extends` but there isn't really point to do it because the `extends` purpose is to configure an element whitout typing more code but it's up to you :). More informations from [extends](extends.md).
