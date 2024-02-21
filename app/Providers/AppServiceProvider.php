<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Base url to server running the dns-dchpd-api https://github.com/yellow-sunshine/dns-dchpd-api
        $dnsDchpdApiUrl = 'http://ns1.daha.us'; // No trailing slash
        
        //Base url to server running the dns-dchpd-api https://github.com/yellow-sunshine/nginx-reverse-proxy-api
        $reverseProxyApiUrl = 'http://reverseproxy.daha.us:8080/'; // No trailing slash

        // Share the variables with all views
        View::share('dnsDchpdApiUrl', $dnsDchpdApiUrl);
        View::share('reverseProxyApiUrl', $reverseProxyApiUrl);
    }
}
