<?php

namespace Modules\Province\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Province\Repositories\EloquentProvincesRepository;
use Modules\Province\Repositories\ProvincesRepositoryInterface;

class ProvinceServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProvincesRepositoryInterface::class, EloquentProvincesRepository::class);
    }
}
