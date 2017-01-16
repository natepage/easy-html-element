<?php

namespace NatePage\HtmlElement\Tests;

use NatePage\HtmlElement\ElementInterface;
use NatePage\HtmlElement\HtmlElement;
use NatePage\HtmlElement\HtmlElementInterface;

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
        $this->assertInstanceOf(ElementInterface::class, HtmlElement::create());
    }

    public function testStaticCreateDiv()
    {
        $this->assertEquals(HtmlElement::create('div', $this->textInDiv), $this->renderDiv());
    }

    public function testStaticCreateDivWithAttribute()
    {
        $div = HtmlElement::create('div', $this->textInDiv, array($this->divAttr => 'value'));

        $this->assertEquals($div, $this->renderDivWithAttribute());
    }

    public function testStaticCreateDivWithChild()
    {
        $div = HtmlElement::create('div', null, array(), array(
            HtmlElement::create('span', $this->textInSpan)
        ));

        $this->assertEquals($div, $this->renderDivWithChild());
    }

    public function testStaticCreateDivWithAttributeAndChildren()
    {
        $div = HtmlElement::create('div', null, array($this->divAttr => 'value'), array(
            HtmlElement::create('h1', $this->textInTitle, array($this->titleAttr => 'value')),
            HtmlElement::create('span', $this->textInSpan, array($this->spanAttr => 'value'))
        ));

        $this->assertEquals($div, $this->renderDivWithAttributeAndChildren());
    }

    public function testStaticDynamicDiv()
    {
        $this->assertEquals(HtmlElement::div($this->textInDiv), $this->renderDiv());
    }

    public function testStaticDynamicDivWithAttribute()
    {
        $div = HtmlElement::div($this->textInDiv, array($this->divAttr => 'value'));

        $this->assertEquals($div, $this->renderDivWithAttribute());
    }

    public function testStaticDynamicDivWithChild()
    {
        $div = HtmlElement::div(null, array(), array(
            HtmlElement::span($this->textInSpan)
        ));

        $this->assertEquals($div, $this->renderDivWithChild());
    }

    public function testStaticDynamicDivWithAttributeAndChildren()
    {
        $div = HtmlElement::div(null, array($this->divAttr => 'value'), array(
            HtmlElement::h1($this->textInTitle, array($this->titleAttr => 'value')),
            HtmlElement::span($this->textInSpan, array($this->spanAttr => 'value'))
        ));

        $this->assertEquals($div, $this->renderDivWithAttributeAndChildren());
    }

    public function testRenderFromTheBottom()
    {
        HtmlElement::div(null, array($this->divAttr => 'value'), array(
            HtmlElement::h1($this->textInTitle, array($this->titleAttr => 'value')),
            $span = HtmlElement::span($this->textInSpan, array($this->spanAttr => 'value'))
        ));

        $this->assertEquals($span, $this->renderDivWithAttributeAndChildren());
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
}
