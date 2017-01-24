<?php

namespace NatePage\EasyHtmlElement\Bridge\Laravel;

use Illuminate\Support\ServiceProvider;
use NatePage\EasyHtmlElement\HtmlElement;

class EasyHtmlElementServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__.'/config/easy_html_element.php';

    protected $defer = true;

    public function register(){
        $this->mergeConfigFrom(self::CONFIG_PATH, 'easy_html_element');

        $this->app->singleton(HtmlElement::class, function(){
            return new HtmlElement(config('easy_html_element.map'));
        });
    }

    public function boot()
    {
        $this->publishes([self::CONFIG_PATH => config_path('easy_html_element.php')]);
    }

    public function provides()
    {
        return [HtmlElement::class];
    }
}
