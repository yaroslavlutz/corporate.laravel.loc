<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
    */
    public function boot()
    {
        //(!!!)прослушивание SQL-запросов. Прописав здесь такое можно видеть сам SQL-запрос,который выполняется и параметры,которые передаются в него. Полезно для отладки и дебага
        /*
            DB::listen( function($query){
                dump($query->sql); //отобразит сам SQL-запрос,котрый в данный момент выполняется
                //dump($query->bindings); //массив тех параметров,которые передаются SQL-запросу (которые привязаны к меткам-placeholder`ам)
            } );
        */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
