#Documentation

####Attributes example
``` php
$map = array(
    'myDiv' => array(
        'type' => 'div',
        'text' => 'Div Attributes Example',
        'attr' => array(
            'id' => 'id-my-div',
            'class' => 'first-class second-class',
            'anything' => 'value'
        )
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
 *      Div Attributes Example
 * </div>
 */
```

You can set every attributes you want on every html element!
