<?php

namespace NickAguilarH\Fortress;

use Illuminate\Support\ServiceProvider;

class FortressServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
}
