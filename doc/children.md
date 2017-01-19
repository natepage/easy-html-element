#Documentation

####Children example
``` php
$map = array(
    'myDiv' => array(
        'type' => 'div',
        'attr' => array(
            'id' => 'id-my-div',
            'class' => 'first-class second-class',
            'anything' => 'value'
        ),
        'children' => array(
            'myTitle',
            'myText'
        )
    ),
    'myTitle' => array(
        'type' => 'h1',
        'text' => 'Title Parent Example'
    ),
    'myText' => array(
        'type' => 'p',
        'text' => 'Lorem ipsum...'
    )
);

$htmlElement = new NatePage\EasyHtmlElement\HtmlElement();
$div = $htmlElement->load('myDiv');

echo $div; 

/**
 * <div id="id-my-div" 
 *      class="first-class second-class" 
 *      anything="value"
 * >
 *      <h1>Title Parent Example</h1>
 *      <p>Lorem ipsum...</p>
 * </div>
 */
```
