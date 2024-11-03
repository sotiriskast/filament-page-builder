<?php

namespace Sotiriskast\FilamentPageBuilder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sotiriskast\FilamentPageBuilder\FilamentPageBuilder
 */
class FilamentPageBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Sotiriskast\FilamentPageBuilder\FilamentPageBuilder::class;
    }
}
