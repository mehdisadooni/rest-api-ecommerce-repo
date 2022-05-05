<?php

namespace Modules\Core\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
//
//    /**
//     * Register the service provider.
//     *
//     * @return void
//     */
    public function register()
    {
        //
    }

}
