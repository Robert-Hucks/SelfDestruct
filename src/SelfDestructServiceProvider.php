<?php

namespace RobertHucks\SelfDestruct;

use Illuminate\Support\ServiceProvider;

class SelfDestructServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
    }

    public function register()
    {
        $this->app->singleton('RobertHucks.SelfDestruct.Console.Kernel', function($app) {
            $dispatcher = $app->make(\Illuminate\Contracts\Events\Dispatcher::class);
            return new \RobertHucks\SelfDestruct\Console\Kernel($app, $dispatcher);
        });

        $this->app->make('RobertHucks.SelfDestruct.Console.Kernel');
    }
}