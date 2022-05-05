<?php

namespace Modules\Province\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Province\Repositories\EloquentProvincesRepository;
use Modules\Province\Repositories\ProvincesRepositoryInterface;

class ProvinceServiceProvider extends ServiceProvider
{

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Province';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'province';

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
        $this->app->bind(ProvincesRepositoryInterface::class, EloquentProvincesRepository::class);
    }

}
