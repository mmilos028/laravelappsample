<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        //additionaly added to application
        //delete all cache files
        \App\Http\Middleware\CacheKiller::class,
        \App\Http\Middleware\PreventBackHistory::class,
        \App\Http\Middleware\InputTrim::class,

        //because of error page, missing session object on error page if startSession middleware not here
        \App\Http\Middleware\StartSession::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            //\Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            //\App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        //'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        //'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        //'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        /**** OTHER MIDDLEWARE ****/
        //localization middleware
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        // REDIRECTION MIDDLEWARE
        'isUserAuthenticated' => \App\Http\Middleware\IsUserAuthenticated::class,
        'redirectIfUserAuthenticated' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        //save and maintain user's session Middleware
        'saveUserDefaultDate' => \App\Http\Middleware\SaveUserDefaultDate::class,
        'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
        'validateSession' => \App\Http\Middleware\ValidateSession::class,
        'checkBackofficeUserPermissions' => \App\Http\Middleware\CheckBackofficeUserPermissions::class
    ];
}
