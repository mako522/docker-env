<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        

      // 管理者以上に許可
      Gate::define('admin-higher', function ($user) {
        return ($user->role >= 1 && $user->role <= 10);
      });
      // 一般ユーザー以上に許可
      Gate::define('user-higher', function ($user) {
        return ($user->role > 10 && $user->role <= 100);
      });
    }
}
