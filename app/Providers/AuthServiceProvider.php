<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use App\Policies\ArticlePolicy;
use App\Article;
use App\Policies\PermissionPolicy;
use App\Permission;
use App\Policies\MenuPolicy;
use App\Menu;
use App\Policies\UserPolicy;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class, //register authorize policy `ArticlePolicy` for model `Article`
        Permission::class => PermissionPolicy::class, //register authorize policy `PermissionPolicy` for model `Permission`
        Menu::class => MenuPolicy::class, //register authorize policy `MenuPolicy` for model `Menu`
        User::class => UserPolicy::class, //register authorize policy `MenuPolicy` for model `Menu`
    ];

    /** Register any authentication / authorization services.
     * @return void
     * @internal param GateContract $gate
    */
    public function boot()
    {
        $this->registerPolicies();

        /* Регистрируем условие для проверки прав Пользователей
                - VIEW_ADMIN_PANEL - право просматривать Гл.страницу панели Администратора
        */
//        Gate::define('VIEW_ADMIN_PANEL', function( $user ) {
//            return $user->userCanDo('VIEW_ADMIN_PANEL'); //наш метод `canDo()` Модели `User` - будет возвращать TRUE, если у пользователя есть соответствующее право,имя которого передается в `canDo()`
//        });


    }

}
