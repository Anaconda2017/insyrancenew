<?php

namespace App\Providers;

use App\About;
use App\Service;
use App\ContactUs;
use App\BannerImage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //  $this->app->bind('path.public', function() {
        //     return realpath(base_path().'/../public_html/insurance');
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    

        
    }
}
