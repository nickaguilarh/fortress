<?php

namespace NickAguilarH\Fortress;

use Illuminate\Support\ServiceProvider;
use NickAguilarH\Fortress\Commands\GenerateCommand;
use NickAguilarH\Fortress\Commands\MigrationCommand;

class FortressServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->registerCommands();

    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/fortress.php' => config_path('fortress.php'),
        ], 'config');
    }

    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationCommand::class,
                GenerateCommand::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.fortress.migration'
        ];
    }
}
