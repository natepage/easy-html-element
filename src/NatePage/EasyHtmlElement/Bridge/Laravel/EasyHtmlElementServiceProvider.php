<?php

namespace NatePage\EasyHtmlElement\Bridge\Laravel;

use Illuminate\Support\ServiceProvider;
use NatePage\EasyHtmlElement\HtmlElement;

class EasyHtmlElementServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__.'/config/easy_html_element.php';

    protected $defer = true;

    public function register(){
        $this->app->singleton(HtmlElement::class, function($app){
            $config = $app['config']['easy_html_element'];

            $map = $config['map'];
            $encoding = $config['encoding'];
            $escaperClass = $config['escaper'];
            $branchValidatorClass = $config['branch_validator'];
            $escaping = $config['escaping'];

            $escaper = new $escaperClass($encoding);
            $escaper
                ->setEscapeHtml($escaping['html'])
                ->setEscapeHtmlAttr($escaping['html_attr'])
                ->setEscapeCss($escaping['css'])
                ->setEscapeJs($escaping['js'])
                ->setEscapeUrl($escaping['url'])
            ;

            $htmlElement = new HtmlElement($map);

            $branchValidator = new $branchValidatorClass($htmlElement);

            $htmlElement
                ->setEscaper($escaper)
                ->setBranchValidator($branchValidator)
            ;

            return $htmlElement;
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
