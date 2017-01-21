<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Children

Elements children are defined in an array under the `children` key. To define an element as child just put its name in the array or it can be an [dynamic element](dynamic_elements.md).

```php
$map = array(
    'child1' => array(/* element definition */),
    'child2' => array(/* element definition */),
    //...
    'element' => array(
        //...
        'children' => array(
            'child1',
            'child2'
        )
    )
);
```

All the element children will be framed in the generated HTML tag. See the next example:

```php
$map = array(
    'title' => array('type' => 'h1', 'text' => 'My title'),
    'span' => array('type' => 'span', 'text' => 'My span'),
    
    'div' => array(
        'type' => 'div',
        'children' => array(
            'title',
            'span'
        )
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

echo $htmlElement->div();

/**
 * <div>
 *      <h1>My title</h1>
 *      <span>My span</span>
 * </div>
 */
```

####Children tree

If an element defines a child which defines children too all the tree will be generated:

```php
$map = array(
    'table' => array(
        'type' => 'table',
        'children' => array(
            'row1',
            'row2'
        )
    ),
    'row1' => array(
        'type' => 'tr',
        'children' => array(
            'cellRow1'
        )
    ),
    'cellRow1' => array(
        'type' => 'td',
        'text' => 'Cell row 1'
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

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);

echo $htmlElement->table();

/**
 * <table>                      //table
 *      <tr>                    //row1
 *          <td>Cell row 1</td> //cellRow1
 *      </tr>
 *      <tr>                    //row2
 *          <td>Cell row 2</td> //cellRow2
 *      </tr>
 * </table>
 */
```
