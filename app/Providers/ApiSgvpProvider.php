<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ApiSgvpProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('api-sgvp', function(){
            return Http::withOptions([
                'verify' => false,
                'base_uri' => 'http://154.56.43.108:8080/api/'
            ]);
        });
        // Caso precise de autorização
        // $this->app->bind('api-sgvp', function(){
        //     return Http::withOptions([
        //         'verify' => false,
        //         'base_uri' => 'https://jsonplaceholder.typicode.com/'
        //     ])->withHeaders([
        //         'Authorization' => '',
        //     ]);
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
