<?php

namespace Modules\Core\Providers;

use Nwidart\Modules\Module;
use Illuminate\Support\ServiceProvider;


class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->registerTranslations($module);
            $this->registerConfig($module);
//            $this->registerViews($module);
            $this->registerHelpers($module);
            $this->loadMigrations($module);
        }
    }


//    /**
//     * Register views.
//     * @param \Nwidart\Modules\Module $module
//     * @return void
//     */
//    public function registerViews(Module $module)
//    {
//        $viewPath = resource_path('views/modules/' . $module->getLowerName());
//
//        $sourcePath = module_path($module->getName(), 'Resources/views');
//
//        $this->publishes([
//            $sourcePath => $viewPath
//        ], ['views',$module->getLowerName() . '-module-views']);
//
//        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]),$module->getLowerName());
//    }

    /**
     * Register config.
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    protected function registerConfig(Module $module)
    {
        $this->publishes([
            module_path($module->getName(), 'Config/config.php') => config_path($module->getLowerName() . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($module->getName(), 'Config/config.php'), $module->getLowerName()
        );
    }

    /**
     * Register translations.
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    public function registerTranslations(Module $module)
    {
        $langPath = resource_path('lang/modules/' . $module->getLowerName());

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $module->getLowerName());
        } else {
            $this->loadTranslationsFrom(module_path($module->getLowerName(), 'Resources/lang'), $module->getLowerName());
        }
    }

    /**
     * Load migrations for the given module.
     *
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    private function loadMigrations(Module $module)
    {
        $this->loadMigrationsFrom("{$module->getPath()}/Database/Migrations");
    }


    /**
     * register all php files in Support folder in all module
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    public function registerHelpers(Module $module)
    {
        foreach (glob("{$module->getPath()}/Support/*.php") as $filename) {
            require_once($filename);
        }
    }
}
