<?php

namespace Prasanna\WeightBasedShipping\Providers;

use Illuminate\Support\ServiceProvider;

class WeightBasedShippingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'weightbasedshipping');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'prasannacustomshipping');

        $this->loadTranslationsFrom(dirname(dirname(__DIR__)) . '/Admin/src/Resources/lang', 'admin');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/carriers.php', 'carriers'
        );
    }

    /**
     * Get the unique identifier for the module.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'prasanna_weight_based_shipping';
    }

    /**
     * Get the root namespace of the module.
     *
     * @return string
     */
    public function getNamespaceRoot(): string
    {
        return __NAMESPACE__;
    }
}