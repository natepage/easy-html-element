<?php

namespace NatePage\EasyHtmlElement\Tests;

use NatePage\EasyHtmlElement\ElementInterface;
use NatePage\EasyHtmlElement\HtmlElement;
use NatePage\EasyHtmlElement\HtmlElementInterface;

class HtmlElementTest extends \PHPUnit_Framework_TestCase
{
    private $textInDiv = 'my text in div';
    private $textInSpan = 'my text in span';
    private $textInTitle = 'my text in title';
    private $divAttr = 'div-attr';
    private $spanAttr = 'span-attr';
    private $titleAttr = 'title-attr';

    public function testInterfaceInstance()
    {
        $this->assertInstanceOf(HtmlElementInterface::class, new HtmlElement());
    }

    public function testInterfaceElementInstance()
    {
        $html = new HtmlElement(array('myDiv' => array('type' => 'div')));

        $this->assertInstanceOf(ElementInterface::class, $html->load('myDiv'));
    }

    public function testDynamicDiv()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'text' => $this->textInDiv
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->myDiv(), $this->renderDiv());
    }

    public function testMapDiv()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'text' => $this->textInDiv
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv'), $this->renderDiv());
    }

    public function testMapDivWithAttribute()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'text' => $this->textInDiv,
                'attr' => array(
                    $this->divAttr => 'value'
                )
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv'), $this->renderDivWithAttribute());
    }

    public function testMapDivWithChild()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'children' => array(
                    'mySpan'
                )
            ),
            'mySpan' => array(
                'type' => 'span',
                'text' => $this->textInSpan
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv'), $this->renderDivWithChild());
    }

    public function testMapDivWithAttributeAndChildren()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'attr' => array(
                    $this->divAttr => 'value'
                ),
                'children' => array(
                    'myTitle',
                    'mySpan'
                )
            ),
            'mySpan' => array(
                'type' => 'span',
                'text' => $this->textInSpan,
                'attr' => array(
                    $this->spanAttr => 'value'
                )
            ),
            'myTitle' => array(
                'type' => 'h1',
                'text' => $this->textInTitle,
                'attr' => array(
                    $this->titleAttr => 'value'
                )
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv'), $this->renderDivWithAttributeAndChildren());
    }

    public function testMapSpanWithAttributeAndParent()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'attr' => array(
                    $this->divAttr => 'value'
                ),
                'children' => array(
                    'myTitle'
                )
            ),
            'mySpan' => array(
                'type' => 'span',
                'parent' => 'myDiv',
                'text' => $this->textInSpan,
                'attr' => array(
                    $this->spanAttr => 'value'
                )
            ),
            'myTitle' => array(
                'type' => 'h1',
                'text' => $this->textInTitle,
                'attr' => array(
                    $this->titleAttr => 'value'
                )
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('mySpan'), $this->renderDivWithAttributeAndChildren());
    }

    public function testMapDivWithAttributeAndDynamicChildren()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'attr' => array(
                    $this->divAttr => 'value'
                ),
                'children' => array(
                    'myTitle',
                    array(
                        'name' => 'mySpan',
                        'type' => 'span',
                        'text' => $this->textInSpan,
                        'attr' => array(
                            $this->spanAttr => 'value'
                        )
                    )
                )
            ),
            'myTitle' => array(
                'type' => 'h1',
                'text' => $this->textInTitle,
                'attr' => array(
                    $this->titleAttr => 'value'
                )
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv'), $this->renderDivWithAttributeAndChildren());
    }

    public function testMapDivWithParameter()
    {
        $map = array(
            'myDiv' => array(
                'type' => 'div',
                'text' => '%myDivText%'
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv', array('myDivText' => $this->textInDiv)), $this->renderDiv());
    }

    public function testMapDivWithExtend()
    {
        $map = array(
            'baseDiv' => array(
                'attr' => array(
                    $this->divAttr => 'value'
                )
            ),
            'myDiv' => array(
                'type' => 'div',
                'text' => $this->textInDiv,
                'extends' => 'baseDiv'
            )
        );

        $htmlElement = new HtmlElement($map);

        $this->assertEquals($htmlElement->load('myDiv'), $this->renderDivWithAttribute());
    }

    public function testMultipleDivWithParameters()
    {
        $map = array(
            'div' => array(
                'type' => 'div',
                'text' => '%text%'
            )
        );

        $htmlElement = new HtmlElement($map);

        $firstDiv = $htmlElement->load('div', array('text' => 'My first div'));
        $secondDiv = $htmlElement->load('div', array('text' => 'My second div'));

        $this->assertEquals($firstDiv . $secondDiv, $this->renderMultipleDivWithParameters());
    }

    private function renderDiv()
    {
        return sprintf('<div>%s</div>', $this->textInDiv);
    }

    private function renderDivWithAttribute()
    {
        return sprintf('<div %s="value">%s</div>', $this->divAttr, $this->textInDiv);
    }

    private function renderDivWithChild()
    {
        return sprintf('<div><span>%s</span></div>', $this->textInSpan);
    }

    private function renderDivWithAttributeAndChildren()
    {
        return sprintf('<div %s="value"><h1 %s="value">%s</h1><span %s="value">%s</span></div>',
            $this->divAttr,
            $this->titleAttr,
            $this->textInTitle,
            $this->spanAttr,
            $this->textInSpan
        );
    }

    private function renderMultipleDivWithParameters()
    {
        return '<div>My first div</div><div>My second div</div>';
    }
}
