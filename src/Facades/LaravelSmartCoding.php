<?php

namespace Alive2212\LaravelSmartCoding\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSmartCoding extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-smart-coding';
    }
}
