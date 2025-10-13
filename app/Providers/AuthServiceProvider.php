<?php

namespace App\Providers;

use App\Models\Survey; 
use App\Policies\SurveyPolicy; 
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * DITAMBAHKAN: The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Survey::class => SurveyPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Kode Gate::define Anda yang lama bisa tetap ada atau dihapus
        // karena sekarang kita menggunakan Policy yang lebih kuat.
        Gate::define('access-admin-dashboard', function ($user) {
            return $user->role_id === 1 || $user->role_id === 2; // Lebih baik pakai role_id
        });
    }
}
