<?php

namespace Sharan\Security;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register the package with the application.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfigs();
    }

    /**
     * Bootstrap the package with the application..
     *
     * @return void
     */
    public function boot()
    {
        $this->publishContents();

        if (config('security.enabled', true)) {
            $this->bootPreventLazyLoading();

            $this->bootForceHttps();

            $this->bootMiddlewares();
        }
    }

    /**
     * Registers the package config with the application's config.
     *
     * @return void
     */
    private function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/security.php', 'security');
    }

    /**
     * Publish the required Contents to the Application Directory.
     *
     * @return void
     */
    private function publishContents()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/security.php' => config_path('security.php')
            ], 'security-config');
        }
    }

    /**
     * @return void
     */
    private function bootPreventLazyLoading()
    {
        if (config('security.standards.prevent_lazy_loading', true)) {
            if (method_exists(Model::class, 'preventLazyLoading')) {
                Model::preventLazyLoading(!app()->isProduction());
            }
        }
    }

    /**
     * Force Https based on incoming protocol.
     *
     * @return void
     */
    private function bootForceHttps()
    {
        if (config('security.standards.force_https', true)) {
            if (request()->header('x-forwarded-proto') == 'https' || $this->app->isProduction()) {
                $this->app['request']->server->set('HTTPS', true);
            }
        }
    }

    /**
     * Register Middlewares to the Web Middleware Group.
     *
     * @return void
     */
    private function bootMiddlewares()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', \Sharan\Security\Middlewares\SecurityHeaderMiddleware::class);
    }
}
