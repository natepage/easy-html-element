<?php

namespace NatePage\EasyHtmlElement\Bridge\Symfony;

use NatePage\EasyHtmlElement\Bridge\Symfony\DependencyInjection\EasyHtmlElementExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EasyHtmlElementBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtensionClass(): string
    {
        return EasyHtmlElementExtension::class;
    }
}
