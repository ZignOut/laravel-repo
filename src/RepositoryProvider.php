<?php

namespace Zignout\LaravelRepo;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Console' => app_path('Console'),
            __DIR__.'/Providers' => app_path('Providers'),
            __DIR__.'/Repository' => app_path('Repository'),
            __DIR__.'/stubs' => 'stubs'
        ]);
    }
}
