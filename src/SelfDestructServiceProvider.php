<?php

namespace RobertHucks\SelfDestruct;

use Illuminate\Support\ServiceProvider;

class SelfDestructServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'src/Database/migrations');
    }

    public function register()
    {
        //
    }
}