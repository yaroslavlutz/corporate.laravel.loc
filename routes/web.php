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

Route::get('404',['uses'=>'ErrorHandlerController@errorCode404'])->name('404');
Route::get('405',['uses'=>'ErrorHandlerController@errorCode405'])->name('405');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('locale/ru', function() {
    Session::put('locale', 'ru');
    return redirect()->back();
})->name('locale_ru');
Route::get('locale/en', function() {
    Session::put('locale', 'en');
    return redirect()->back();
})->name('locale_en');


Route::get('tag/create', [  // tag/create?text={value}
    'middleware' => ['auth'],
    'uses' => 'TagController@create'
]);
Route::get('tag/{id}', [  // tag/{id}
    'uses' => 'TagController@show'
]);

Route::group( ['middleware'=>['web'] ], function() {
    Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('provider_login');
    Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

    Route::resource('/', 'IndexResourceController', [
        'only'=>['index'],
        'names'=>['index'=>'home']
    ]);

    Route::resource('articles', 'ArticleResourceController', [
        'names'=>['index'=>'articles'],
        'parameters' => [ 
                'articles' => 'alias'
            ]
    ]);
        Route::get('articles/cat/{cat?}', ['uses'=>'ArticleResourceController@index', 'as'=>'articles_cat']); 

        Route::resource('comment', 'CommentResourceController', [
            ['only'=>['store'], 'names'=>['store'=>'save_comment']]
        ]);

    Route::resource('portfolios', 'PortfolioResourceController', [
        'names'=>['index'=>'portfolios'],
        'parameters' => [
            'portfolios' => 'alias'
        ]
    ]);

        Route::get('portfolios/cat/{alias?}', ['uses'=>'PortfolioResourceController@index', 'as'=>'portfolios_cat']);

    Route::resource('contacts', 'ContactResourceController', [
        'only'=>['index','store'],
        'names'=>['index'=>'contacts']
    ]);

});

Route::group( [ 'prefix'=>'admin', 'middleware'=>['auth'] ], function() {

    Route::resource('/', 'Admin\IndexResourceController', [
        'only'=>['index'],
        'names'=>['index'=>'admin_home']
    ]);

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
            'articles' => 'alias'
        ]
    ]);

    Route::resource('/admin-portfolios', 'Admin\PortfolioResourceController', [
        'names'=>['index'=>'admin_portfolios'],
        'parameters' => [
            'portfolios' => 'alias'
        ]
    ]);

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
            'menus' => 'menu'
        ]
    ]);

    Route::resource('/admin-articles-categories', 'Admin\MenuResourceController', [
        'names'=>['index'=>'admin_articles_categories']
    ]);

    Route::resource('/admin-portfolio-filters', 'Admin\PortfolioFilterResourceController', [
        'names'=>['index'=>'admin_portfolio_filters']
    ]);

    Route::resource('/admin-sliders', 'Admin\SliderResourceController', [
        'names'=>['index'=>'admin_sliders']
    ]);

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

    Route::resource('/admin-permissions', 'Admin\PermissionResourceController', [
        'names'=>[
            'index'=>'admin_permissions',
            'store'=>'admin_permissions_add_new',
        ]
    ]);

});
