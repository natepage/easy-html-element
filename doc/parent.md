# Documentation

####Parent example
``` php
$map = array(
    'myDiv' => array(
        'type' => 'div',
        'attr' => array(
            'id' => 'id-my-div',
            'class' => 'first-class second-class',
            'anything' => 'value'
        )
    ),
    'myTitle' => array(
        'type' => 'h1',
        'text' => 'Title Parent Example',
        'parent' => 'myDiv'
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement();
$div = $htmlElement->load('myTitle');

echo $div; 

/**
 * <div id="id-my-div" 
 *      class="first-class second-class" 
 *      anything="value"
 * >
 *      <h1>Title Parent Example</h1>
 * </div>
 */
```
We displayed the title in the div with the attributes from the previous example with just one method!
