<?php

namespace Modules\Purchase\Providers;

use Illuminate\Support\ServiceProvider;

class PurchaseServiceProvider extends ServiceProvider
{

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Purchase';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'purchase';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
