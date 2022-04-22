<?php

namespace Modules\Brand\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Brand\Repositories\BrandsRepositoryInterface;
use Modules\Brand\Repositories\EloquentBrandsRepository;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->bind(BrandsRepositoryInterface::class, EloquentBrandsRepository::class);
    }

}
