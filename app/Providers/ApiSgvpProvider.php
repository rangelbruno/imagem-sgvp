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
                'base_uri' => 'https://sgvp-backend-api.herokuapp.com/api/'
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
