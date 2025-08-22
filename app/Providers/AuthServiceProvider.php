<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'admin-satker') {
                return $user;
            };
        });
        
        Gate::define('admin-provinsi', function (User $user) {
            if ($user->role == 'admin-provinsi') {
                return $user;
            };
        });

        Gate::define('approver', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'approver') {
                return $user;
            };
        });

        Gate::define('supervisor', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'supervisor') {
                return $user;
            };
        });

        Gate::define('evaluator', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'supervisor' || $user->role == 'evaluator') {
                return $user;
            };
        });      

        Gate::define('kabkot', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'admin-satker' || $user->role == 'viewer') {
                return $user;
            };
        });

        Gate::define('user-akip', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'admin-satker' || $user->role == 'evaluator'|| $user->role == 'supervisor-akip'|| $user->role == 'viewer') {
                return $user;
            };
        });
                
        Gate::define('supervisor-akip', function (User $user) {
            if ($user->role == 'admin-provinsi' || $user->role == 'supervisor-akip' || $user->role == 'evaluator') {
                return $user;
            };
        });

        Gate::define('user-provinsi', function (User $user) {
            if ($user->satker_id == '1' ) {
                return $user;
            };
        });
    }
}
