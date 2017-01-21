<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Parent

Elements parent is defined under the `parent` key. It can be another element name or an [dynamic element](dynamic_elements.md). An element can only have one parent which will frame it. But if you want to define the parent in relation to a particular case you can do it with a [parameter](parameters.md).
 
```php
$map = array(
    'elementParent' => array(/* element definition */),
     
    //...
    'element' => array(
        //...
        'parent' => 'elementParent'
    )
);
```
 
####Simple parent
 
```php
$map = array(
    'div' => array('type' => 'div'),
      
    'span' => array(
        'type' => 'span',
        'text' => 'My span',
        'parent' => 'div'
    )
);
  
$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);
  
echo $htmlElement->span();
  
/**
 * <div>
 *    <span>My span</span>
 * </div>
 */
```
  
####Parent tree
  
If an element defines a parent which defines a parent too all the tree will be generated:

```php
$map = array(
    'div' => array('type' => 'div'),
    
    'title' => array(
        'type' => 'h1',
        'parent' => 'div'
    ),
      
    'span' => array(
        'type' => 'span',
        'text' => 'My span in title',
        'parent' => 'title'
    )
);
  
$htmlElement = new NatePage\EasyHtmlElement\HtmlElement($map);
  
echo $htmlElement->span();
  
/**
 * <div>
 *    <h1>  
 *      <span>My span in title</span>
 *    </h1>
 * </div>
 */
```
