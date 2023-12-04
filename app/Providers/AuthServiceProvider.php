<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Permissions;
use App\Policies\BuildingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        //

//        Gate::define('list_building',[BuildingPolicy::class,'view']);

        $this->defineGate();
    }

    public function defineGate()
    {
        $keyCodeOfPermissions = Permissions::where('key_code', '!=', '')->get('key_code')->pluck('key_code');
        foreach ($keyCodeOfPermissions as $keyCodeOfPermission) {
            Gate::define($keyCodeOfPermission, function ($user) use ($keyCodeOfPermission) {
                return $user->checkPermissionAccess($keyCodeOfPermission);
            });
        }

    }
}
