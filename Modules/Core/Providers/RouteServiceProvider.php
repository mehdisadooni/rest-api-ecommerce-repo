<?php

namespace Modules\Core\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Module;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Core\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->configureRateLimiting();
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->mapApiRoutes($module);
            $this->mapWebRoutes($module);
        }

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    protected function mapWebRoutes(Module $module)
    {
        $path = module_path($module->getName(), '/Routes/web.php');
        if (!file_exists($path)) {
            return;
        }
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group($path);
    }

    /**
     * Define the "api" routes for the application.
     * @param \Nwidart\Modules\Module $module
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(Module $module)
    {
        $path = module_path($module->getName(), '/Routes/api.php');
        if (!file_exists($path)) {
            return;
        }
        Route::prefix('api')
            ->middleware('api')
//            ->namespace($this->moduleNamespace)
            ->group($path);
    }


    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
