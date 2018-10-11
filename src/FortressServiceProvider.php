<?php

namespace NickAguilarH\Fortress;

use Illuminate\Support\ServiceProvider;

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
        $this->publishMigrations();
        $this->registerCommands();

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationCommand::class,
            ]);
        }
    }

    public function publishMigrations(){
        if (! class_exists('CreateRolesTables')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_roles_tables.php' => $this->app->databasePath()."/migrations/{$timestamp}_create_roles_tables.php",
            ], 'migrations');
        }
    }
    public function publishConfig(){
        $this->publishes([
            __DIR__ . '/../config/fortress.php' => config_path('fortress.php'),
        ], 'config');
    }


    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.Fortress.migration'
        ];
    }
}
