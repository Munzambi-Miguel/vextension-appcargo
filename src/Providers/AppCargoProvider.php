<?php

namespace AppCargo\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppCargoProvider extends ServiceProvider
{

    public function boot(): void
    {

        Vite::prefetch(concurrency: 3);

        \Log::info(date("d-m-Y H:i:s") . " Modulo de Apolice e Plano");
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
    }

    public function register(): void
    {

    }
}