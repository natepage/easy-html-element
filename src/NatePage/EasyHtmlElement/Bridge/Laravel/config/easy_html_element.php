<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Encoding
     |--------------------------------------------------------------------------
     |
     | By default encoding is utf-8, if you want to change it you have to use
     | and encoding format supported by htmlspecialchars().
     |
     */
    'encoding' => 'utf-8',

    /*
     |--------------------------------------------------------------------------
     | Escaper class
     |--------------------------------------------------------------------------
     |
     | If you want to use your own escaper it must implement
     | NatePage\EasyHtmlElement\EscaperInterface.
     |
     */
    'escaper' => \NatePage\EasyHtmlElement\Escaper::class,

    /*
     |--------------------------------------------------------------------------
     | Branch Validator class
     |--------------------------------------------------------------------------
     |
     | If you want to use your own branch validator it must implement
     | NatePage\EasyHtmlElement\BranchValidatorInterface.
     |
     */
    'branch_validator' => \NatePage\EasyHtmlElement\BranchValidator::class,

    /*
     |--------------------------------------------------------------------------
     | Escaping strategies
     |--------------------------------------------------------------------------
     |
     | By default all escaping strategies are applied. If you want to disable a
     | strategy change its value to false.
     |
     */
    'escaping' => [
        'html' => true,
        'html_attr' => true,
        'css' => true,
        'js' => true,
        'url' => true
    ],

    /*
     |--------------------------------------------------------------------------
     | Elements map
     |--------------------------------------------------------------------------
     |
     | Define your elements here.
     |
     */
    'map' => []
];
