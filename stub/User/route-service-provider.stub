<?php
namespace App\Domain\User\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
    * The path to the "home" route for your application.
    *
    * This is used by Laravel authentication to redirect users after login.
    *
    * @var string
    */
    public const HOME = '/home';

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Domain\User\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix(config('system.admin.prefix'))
            ->namespace($this->namespace)
            ->group(app_path('Domain/User/Routes/web/public.php'));

        Route::middleware('web')
            ->prefix(config('system.admin.prefix'))
            ->namespace($this->namespace)
            ->group(app_path('Domain/User/Routes/web/guest.php'));

        Route::middleware('web')
            ->prefix(config('system.admin.prefix'))
            ->namespace($this->namespace)
            ->group(app_path('Domain/User/Routes/web/auth.php'));

    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(app_path("Domain/User/Routes/api/public.php"));

        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(app_path("Domain/User/Routes/api/guest.php"));
        
        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(app_path("Domain/User/Routes/api/auth.php"));
    }
}
