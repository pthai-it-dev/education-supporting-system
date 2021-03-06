<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot ()
    {
        $this->registerPolicies();

        Auth::provider('custom', function ($app, array $config)
        {
            return new CustomUserProvider($app['hash'], $config['model']);
        });

        Gate::define('update-schedule', function (Account $user, array $input)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();
            return in_array(10, $permissions);
        });

        Gate::define('get-teacher-fixed-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();

            return in_array(29, $permissions);
        });

        Gate::define('get-department-fixed-schedule', function (Account $user, array $input)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();
            return in_array((isset($input['page']) || isset($input['pagination']) ? 30 : 28),
                $permissions);
        });

        Gate::define('get-fixed-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();
            return in_array(31, $permissions);
        });

        Gate::define('get-teacher-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();

            return in_array(6, $permissions);
        });

        Gate::define('get-department-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();

            return in_array(7, $permissions);
        });

        Gate::define('get-teacher-exam-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();

            return in_array(5, $permissions);
        });

        Gate::define('get-department-exam-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();

            return in_array(8, $permissions);
        });

        Gate::define('update-exam-schedule', function (Account $user)
        {
            $permissions = Role::find($user->id_role)->permissions()
                               ->pluck('permissions.id')->toArray();

            return in_array(11, $permissions);
        });
    }
}
