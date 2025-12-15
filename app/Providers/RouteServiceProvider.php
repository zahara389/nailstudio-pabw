<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Tentukan namespace untuk Controller Anda.
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Tentukan map routing aplikasi.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Tentukan rute untuk aplikasi yang dimaksudkan sebagai stateless (API).
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // <--- INI KUNCI UTAMA MASALAH ANDA
             ->middleware('api')
             ->namespace($this->namespace) // Opsional, tergantung versi
             ->group(base_path('routes/api.php'));
    }

    /**
     * Tentukan rute untuk aplikasi yang dimaksudkan sebagai web.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace) // Opsional, tergantung versi
             ->group(base_path('routes/web.php'));
    }

    /**
     * Tentukan batas rate limit untuk API.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Panggil konfigurasi rate limit.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->map();
    }
}