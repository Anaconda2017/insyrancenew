<?php

namespace App\Providers;

use App\About;
use App\Service;
use App\ContactUs;
use App\BannerImage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

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

        Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

         \Illuminate\Support\Facades\Response::macro('noCache', function ($response) {
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', '0');
        });

        // إضافة global hook على كل Response
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Routing\Events\ResponseSending::class,
            function ($event) {
                $event->response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
                $event->response->headers->set('Pragma', 'no-cache');
                $event->response->headers->set('Expires', '0');
            }
        );
        
        Schema::defaultStringLength(191);
    

        
    }
}
