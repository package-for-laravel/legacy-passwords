<?php
/**
 * Service Provider for this package
 */
declare(strict_types=1);

namespace AaronSaray\LaravelLegacyPasswords;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Event;

/**
 * Class ServiceProvider
 * @package AaronSaray\LaravelLegacyPasswords
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * But up our configurations/migrations, etc
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        Auth::provider('laravel-legacy-passwords', function () {
            return new AuthenticationService(
                $this->app->make(LegacyPasswordAuthenticationStrategyContract::class),
                $this->app->make(Hasher::class),
                $this->app->make(Dispatcher::class),
                $this->app['config']['auth']['providers']['users']['model']
            );
        });
        
        Event::listen(LegacyPasswordAuthenticationEvent::class, LegacyPasswordConversionListener::class);
    }
}