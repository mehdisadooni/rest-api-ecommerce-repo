<?php

namespace Modules\City\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\City\Repositories\CitiesRepositoryInterface;
use Modules\City\Repositories\EloquentCitiesRepository;

class CityServiceProvider extends ServiceProvider
{

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'City';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'city';

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CitiesRepositoryInterface::class, EloquentCitiesRepository::class);
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
