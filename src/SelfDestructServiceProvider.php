<?php

namespace roberthucks\selfdestruct;

use Illuminate\Support\ServiceProvider;

class SelfDestructServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
    }

    public function register()
    {
        $this->app->singleton('roberthucks.selfdestruct.Console.Kernel', function($app) {
            $dispatcher = $app->make(\Illuminate\Contracts\Events\Dispatcher::class);
            return new \roberthucks\selfdestruct\Console\Kernel($app, $dispatcher);
        });

        $this->app->make('roberthucks.selfdestruct.Console.Kernel');
    }
}