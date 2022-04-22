<?php

namespace Modules\City\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\City\Repositories\CitiesRepositoryInterface;
use Modules\City\Repositories\EloquentCitiesRepository;

class CityServiceProvider extends ServiceProvider
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
        $this->app->bind(CitiesRepositoryInterface::class, EloquentCitiesRepository::class);
    }
}
