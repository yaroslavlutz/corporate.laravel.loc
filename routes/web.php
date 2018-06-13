<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Закомменченный стандартный(по умолчанию) роут на страницу приветствия Laravel
Route::get('/', function () {
    return view('welcome');
});
*/
/** 0) ERROR ROUTES `404` and `405`.
For redirect on View with special content
 */ /*!! Раскоментить,когда проект в продакшене. И в `app/Exceptions/Handler.php` в методе `public function render()` раскоментировать !! */
//Route::get('404',['uses'=>'ErrorHandlerController@errorCode404'])->name('404');
//Route::get('405',['uses'=>'ErrorHandlerController@errorCode405'])->name('405');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home'); //Route::get('/home', ['uses'=>'HomeController@index', 'as'=>'admin_home']); //для того,чтобы не переделывать станд.роут для пути '/home' и чтобы попадать с него в Админку

/** Управление/Смена языковой локали */
Route::get('locale/ru', function() { //Выбрали русскую локализацию для сайта
    Session::put('locale', 'ru');  //Записываем в сессию в переменную $locale зн-е 'ru'
    return redirect()->back(); //Редиректим его <s>взад</s> на ту же страницу
})->name('locale_ru');
Route::get('locale/en', function() { //Выбрали английскую локализацию для сайта
    Session::put('locale', 'en'); //Записываем в сессию в переменную $locale зн-е 'en'
    return redirect()->back(); //Редиректим его <s>взад</s> на ту же страницу
})->name('locale_en');



/** Test Area */
/* Create new tag */
Route::get('tag/create', [  // tag/create?text={value}
    'middleware' => ['auth'], //available only to authenticated users
    'uses' => 'TagController@create'
]);
/* Show tag */
Route::get('tag/{id}', [  // tag/{id}
    'uses' => 'TagController@show'
]);
/**__/Test Area */







/** Роуты для RESTful Resource Controllers */
/*
    По умолчанию форма записи роутера - Route::resource('/pages', 'Admin\ResourceController')  для RESTful Resource Controllers подразумевает все методы HTTP-запросов,
    которые будут сгенирированны в Контроллере(index, create, store, show, edit, update, destroy), но можно указать только те,кот.мы хотим использовать и отсечь возможность
    использовать другие. Например:
    Route::resource('/pages', 'Admin\ResourceController', ['only'=>['index','show']]); тогда методы HTTP-запросов create,store,edit,update,destroy будут недоступны
        или
    Route::resource('/pages', 'Admin\ResourceController', ['except'=>['index','show']]); тогда только методы HTTP-запросов 'index' и 'show' будут недоступны, остальные доступны!
*/
/** 1) FOR FRONTEND part.
*/
Route::group( ['middleware'=>['web'] ], function() {  //or: Route::group( ['middleware'=>'web'], function() {

    /** Authorization and logging with Socialite (Google/Facebook/Twitter/GitHub... */
    Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('provider_login');
    Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


    /** 1.1__________________Home page show - For:'/' */
    Route::resource('/', 'IndexResourceController', [
        'only'=>['index'],
        'names'=>['index'=>'home']
    ]); //Нам нужен только метод `index` и мы именуем роут только для этого метода и называем его `home`

    /** 1.2__________________Blog page - For:'/articles' */
    Route::resource('articles', 'ArticleResourceController', [
        'names'=>['index'=>'articles'],
        'parameters' => [   //For:'/articles/{alias}' (alias = article1,article2,article3...)
                'articles' => 'alias' //переименовываем стандартное имя для такого маршрута 'articles' на 'alias'
            ]
    ]);
            /* For:'//articles/cat/{cat}' */
        Route::get('articles/cat/{cat?}', ['uses'=>'ArticleResourceController@index', 'as'=>'articles_cat']); //OR: where('cat','[A-Za-z]+')  //[^a-zA-Z0-9-]  //[^a-zA-Z0-9-_.]
            /* Save comment. /For:'/articles/{alias}' (alias = article1,article2,article3...) */
        Route::resource('comment', 'CommentResourceController', [
            ['only'=>['store'], 'names'=>['store'=>'save_comment']]  //Метод `store` используется в REST-системах для сохранения данных в БД
        ]);

    /** 1.3__________________Portfolio page - For:'/portfolios' */
    Route::resource('portfolios', 'PortfolioResourceController', [
        'names'=>['index'=>'portfolios'],
        'parameters' => [
            'portfolios' => 'alias' //переименовываем стандартное имя для такого маршрута 'portfolios' на 'alias'
        ]
    ]);
            /* For:'//portfolios/cat/{alias}' */
        Route::get('portfolios/cat/{alias?}', ['uses'=>'PortfolioResourceController@index', 'as'=>'portfolios_cat']);

    /** 1.4__________________Contacts page - For:'/contacts' */
    Route::resource('contacts', 'ContactResourceController', [
        'only'=>['index','store'],
        'names'=>['index'=>'contacts']
    ]);

}); //__/Route::group( ['middleware'=>['web'] ]


/** 2) FOR BACKEND part (Admin-Panel).
    Поэтому для всей такой группы мы определяем префикс,а именно - `admin`. Т.е. у нас вся группа маршрутов будет начинаться одинаково  - с `admin`.
    В эту часть раздела сайта можно будет попасть только после Логинации
*/
Route::group( [ 'prefix'=>'admin', 'middleware'=>['auth'] ], function() {

    /** 2.1__________________Home page show - For:'/admin' */
    Route::resource('/', 'Admin\IndexResourceController', [
        'only'=>['index'],
        'names'=>['index'=>'admin_home']
    ]);
    /** 2.2__________________Articles - For:'/admin/admin-articles' */
    Route::resource('/admin-articles', 'Admin\ArticleResourceController', [
        'names'=>[
            'index'=>'admin_articles',
            'create'=>'admin_articles_create',
            'store'=>'admin_articles_add_new',
            'edit'=>'admin_articles_edit',
            'update'=>'admin_articles_update',
            'destroy'=>'admin_articles_delete'
        ],
        'parameters' => [
            'articles' => 'alias' //переименовываем стандартное имя для такого маршрута 'articles' на 'alias'
        ]
    ]);
    /** 2.3__________________Portfolios - For:'/admin/admin-portfolios' */
    Route::resource('/admin-portfolios', 'Admin\PortfolioResourceController', [
        'names'=>['index'=>'admin_portfolios'],
        'parameters' => [   //For:'/admin/admin-portfolio/{alias}' (alias = article1,article2,article3...)
            'portfolios' => 'alias' //переименовываем стандартное имя для такого маршрута 'portfolios' на 'alias'
        ]
    ]);
    /** 2.4__________________Menus - For:'/admin/admin-portfolio' */
    Route::resource('/admin-menus', 'Admin\MenuResourceController', [
        'names'=>[
            'index'=>'admin_menus',
            'create'=>'admin_menus_create',
            'store'=>'admin_menus_add_new',
            'edit'=>'admin_menus_edit',
            'update'=>'admin_menus_update',
            'destroy'=>'admin_menus_delete'
        ],
        'parameters' => [
            'menus' => 'menu' //переименовываем стандартное имя для такого маршрута 'menus' на 'menu'
        ]
    ]);
    /** 2.5__________________Articles Categories - For:'/admin/admin-articles-categories' */
    Route::resource('/admin-articles-categories', 'Admin\MenuResourceController', [
        'names'=>['index'=>'admin_articles_categories']
    ]);
    /** 2.6__________________Portfolio Filters - For:'/admin/admin-portfolio-filters' */
    Route::resource('/admin-portfolio-filters', 'Admin\PortfolioFilterResourceController', [
        'names'=>['index'=>'admin_portfolio_filters']
    ]);
    /** 2.7__________________Sliders - For:'/admin/admin-sliders' */
    Route::resource('/admin-sliders', 'Admin\SliderResourceController', [
        'names'=>['index'=>'admin_sliders']
    ]);
    /** 2.8__________________Users - For:'/admin/admin-users' */
    Route::resource('/admin-users', 'Admin\UserResourceController', [
        'names'=>[
            'index'=>'admin_users',
            'create'=>'admin_users_create',
            'store'=>'admin_users_add_new',
            'edit'=>'admin_users_edit',
            'update'=>'admin_users_update',
            'destroy'=>'admin_users_delete'
        ]
    ]);
    /** 2.9__________________Permissions - For:'/admin/admin-permissions' */
    Route::resource('/admin-permissions', 'Admin\PermissionResourceController', [
        'names'=>[
            'index'=>'admin_permissions',
            'store'=>'admin_permissions_add_new',
        ]
    ]);

});  //__/Route::group( [ 'prefix'=>'admin', 'middleware'=>['auth'] ]