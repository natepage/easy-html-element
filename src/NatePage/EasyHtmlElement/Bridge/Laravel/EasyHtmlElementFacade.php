<?php

namespace NatePage\EasyHtmlElement\Bridge\Laravel;

use Illuminate\Support\Facades\Facade;
use NatePage\EasyHtmlElement\HtmlElement;

class EasyHtmlElementFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HtmlElement::class;
    }
}
