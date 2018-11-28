<?php

namespace LaravModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ModulesAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $module_path=base_path()."/modules";

        if( file_exists(config_path('modules.php'))){
            $module_config=config('modules');
            $module_path=$module_config['module_path'];
        }

        if(is_dir($module_path)){
            $modules=scandir($module_path);

            foreach ($modules as $key => $module) {
                $check=preg_match('/(.)(..)/',$module);
                if($check){
                    $module_name=strtolower($module);
                    $this->loadRoutesFrom(base_path()."/modules/$module/routes/web.php");
                    $this->loadViewsFrom(base_path()."/modules/$module/resources/views", $module_name);
                    $this->loadTranslationsFrom(base_path()."/modules/$module/resources/lang", $module_name);
                }
            }
        }

        $this->publishes(
            [
                __DIR__."/../src/modules.php" => config_path('modules.php')
            ],'modules');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \LaravModule\Commands\MakeModules::class,
            ]);
        }


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}
