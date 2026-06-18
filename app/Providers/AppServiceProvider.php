<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Responses\RegisterResponse as CustomRegisterResponse;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Http\Responses\RegisterResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class,CustomLoginResponse::class);
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        Gate::define('test', function (?User $user) {
            if ($user->name == '管理人４') {
                return true;
            }
            return false;
        });

        Gate::define('test2', function (?User $user) {
            if ($user->name == '管理人４') {
                return true;
            }
            return false;
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null,
        );
    }
}
