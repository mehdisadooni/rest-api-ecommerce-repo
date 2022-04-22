<?php

namespace Modules\Category\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Category\Repositories\CategoriesRepositoryInterface;
use Modules\Category\Repositories\EloquentCategoriesRepository;

class CategoryServiceProvider extends ServiceProvider
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
        $this->app->bind(CategoriesRepositoryInterface::class, EloquentCategoriesRepository::class);
    }


}
