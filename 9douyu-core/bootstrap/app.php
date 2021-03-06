<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

 $app->withFacades();

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

 $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
    \LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class
 ]);

 $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
     'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class,
     'oauth' => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
     'oauth-client' => \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class,
     'oauth-user' => \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class,
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
$app->register(\LucaDegasperi\OAuth2Server\Storage\FluentStorageServiceProvider::class);
$app->register(\LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider::class);
$app->register(Maatwebsite\Excel\ExcelServiceProvider::class);
//class_alias('Maatwebsite\Excel\Facades\Excel', 'Excel');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});

/*
 |-------------------------------------------------------------------------
 | Class Alias
 |-------------------------------------------------------------------------
 | Add class alias here
 */
!class_exists('Authorizer') or class_alias(\LucaDegasperi\OAuth2Server\Facades\Authorizer::class, 'Authorizer');

/*
 |-------------------------------------------------------------------------
 | Pre load configure file
 |-------------------------------------------------------------------------
 | 
 */
$app->configure('app');
$app->configure('api');
$app->configure('oauth2');

app('Dingo\Api\Auth\Auth')->extend('oauth', function ($app) {
    $provider = new Dingo\Api\Auth\Provider\OAuth2($app['oauth2-server.authorizer']->getChecker());

    $provider->setUserResolver(function ($id) {
        // Logic to return a user by their ID.
        return App\User::find($id);
    });

    $provider->setClientResolver(function ($id) {
        // Logic to return a client by their ID.
    });

    return $provider;
});

//日志按天存储,目前保存90天
$app->configureMonologUsing(function(Monolog\Logger $monolog) use ($app) {

    $syslogHandler = \App\Tools\ToolSyslog::getSyslogHandler();
    $monolog->pushHandler($syslogHandler);
    
    return $monolog->pushHandler(
        new \Monolog\Handler\RotatingFileHandler($app->storagePath().'/logs/lumen.log', 90)
    );


});

return $app;
