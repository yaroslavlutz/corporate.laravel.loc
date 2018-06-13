Test accounts - Login / Password:
    1) admin (admin@mail.com) / 331429
    2) littus (littus@i.ua) / 654321
    3) fatHomer (homer@mail.us) / 123456
==================================================================================



_______________________________________________ЭТАПЫ СОЗДАНИЯ ЭТОГО ПРИЛОЖЕНИЯ `corporate.laravel.loc`:*/
- Подключили favicon: см. папку `public/favicon/` и подключение его содержимого в Гл.шаблоне для фронтенд-части - `/var/www/corporate.laravel.loc/resources/views/layouts/main_layout_site_pink.blade.php`.

1) в `.env` добавляем свою переменную окружения: THEME=pink  для установки активной(используемой в данный момент) темы
2) в [config] добавляем свой файл `settings.php` для установки в нем общих настроек для сайта,- таких как размеры загружаемых изображений, типы файлов, кол-во отображаемых материалов на одной
    странице и т.д. См.`config/settings.php`.
3) Определяем структуру БД
    и делаем миграции
        php artisan make:migration create_table_articles --create=articles
        php artisan make:migration create_table_portfolios --create=portfolios
        php artisan make:migration create_table_portfolio_filters --create=portfolio_filters
        php artisan make:migration create_table_comments --create=comments
        php artisan make:migration create_table_sliders --create=sliders
        php artisan make:migration create_table_menus --create=menus
        php artisan make:migration create_table_articles_categories --create=articles_categories
    а также миграции,которые добавят внешние ключи для таблиц: articles, portfolios, comments
        php artisan make:migration add_foreign_key_to_table_comments --table=comments
        php artisan make:migration add_foreign_key_to_table_articles --table=articles
        php artisan make:migration add_foreign_key_to_table_portfolios --table=portfolios
    Наполняем созданные таблицами нужными(начальными) данными.

4) нужно развернуть(по крайней мере странтартный механизм Авторизации и Аутонтефикации Юзера), а для этого в первую очередь нам нужно создать набор View-шаблонов для
       Авторизации и Аутонтефикации Юзера и делаем мы это через команду Консоли LAravel:
           php artisan make:auth
    см.файл `Authentication_&_Autarization.php` и в частности п.1)
    Также вместе с нужными файлами View создасться по умолчанию Контроллер `app/Http/Controllers/HomeController.php`.
    После чего можно попробовать перейти по роуту для Admin-части,который мы сами определили (http://landing.laravel.loc/admin) и нас должно перекинуть на страницу логинации  - /registration
    и зарегистрировать Админа и 2-х Юзеров как тестовых аккаунта (все их данные вверху этого файла).
5) Далее работаем с файлом для роутов и формируем маршруты. См.`routes/web.php`. А также создаем Коннтроллер типа ресурс для работы с RESTful-системами - `app/Http/Controllers/IndexResourceController.php`
6) В данном приложении построим логику так,что для фронтенд-части у нас будет свой общий, Главный(родит.Контроллер), от котрого будут наследоваться все остальные Контроллеры фронтенд-части. И в нем будут
   некоторые общие медоды,которые будут использоваться в др.дочерних Контроллерах,блпг.чему мы не будем дублировать методы.
    Поэтому создаем `SiteMainController.php`. Он нужен,чтобы общие методы и данные,которые нужны для других Контроллеров и вью,которые они рендерят,прописать единожды и не повторять в каждом Контролле.
    К такому функционалу относится,например, получение Меню. Поэтому мы логику по получению меню и его формированию выносим в общий(родит.Контроллер) и прям от туда сразу рендерим во все вью фронтенд-части сайта.

7) Создаем Главный шаблон макет для фронтенд-части сайта - `resources/views/layouts/main_layout_site_pink.blade.php`

8) Тут реализована русская локализация. См.`resources/lang/ru/custom_ru.php` и в `config/app.php` изменена настройка локализации 'locale' => 'ru'
    Сам пример с подстановкой нужного текста(в зависимости от язык.Локали) - см.View - `resources/views/frontendsite/pink/include/_right_side_bar.blade.php`

9) Также, наряду с IndexResourceController,кот. у нас рендерит и передает нужные данные для формиров.и отображен. стр.`HOME` (тут используется метод `index()`), были созданы (см.`routes/web.php`):
        PortfolioResourceController для формирования и отображения отдельных работ Портфолио
        ArticleResourceController  для формирования и отображения отдельных статей Блога
    для которых определены обязат.парам. 'alias' как идентификатор Портфолио/Статьи. См.как строится роут для них в `resources/views/frontendsite/pink/include/_right_side_bar.blade.php`


____________________________Делаем страницу "BLOG":
Это у нас Модель `app/Article.php`.
`Article` связана `1: ко многим` связью с моделью `User` - 1 Юзер может иметь много записей(articles) в табл.`articles`
`Article` связана `1: ко многим` связью с моделью `ArticleCategory` - 1 категория может иметь много записей(articles) в табл.`articles`
`Article` связана `1: ко многим` связью с моделью `Comment` - 1 запись(articles) может иметь много комментариев(comments) в табл.`comments`

`Comment` связана `1: ко многим` связью с моделью `User` - 1 Юзер может иметь много комментариев(comments) в табл.`comments`

________Комментарии к статьям Блога:
Статьи могут добавлять только зарегистрированные Юзеры, а комментарии все Юзеры(как зарегинные так и нет), соответственно в таблицу `comments` так данные и пишутся.
Тут реализована возможность добавлять не только комментарии к статье,а и комментарий на комментарий, т.о. реализована древовидность Комментариев, где есть родительский комментарий(когда комментарий
непосредственно на статью - комментарий верхнего уровня) и дочерний комментарий(когда комментарий на комментарий - дочерний комментарий). Все эти комментарии добавляются AJAX`ом (см.`app/Http/Controllers/CommentResourceController.php`,
`public/js/main.js`, `resources/views/frontendsite/pink/include/_single_article.blade.php`, `resources/views/frontendsite/pink/include/__comments_single_article.blade.php`,
`resources/views/frontendsite/pink/include/__form_add_comment_single_article.blade.php`, `resources/views/frontendsite/pink/include/__comment_one_comment_ajax.blade.php`).
Последний файл-View `resources/views/frontendsite/pink/include/__comment_one_comment_ajax.blade.php` используется исключительно для добавления AJAX`ом комментария,который Юзер добавил только что и нужно это для того,
чтобы показать ему его комментарий без перезагр.стр. Такой коммент- временный коммент он не имеет многих нужных параметров для выстраивания правильно DOM, и отображается с желтым фоном. Когда страницу перезагрузим,
такой коммент правильно подтянется в DOM и займет правильную структуру с нужными данными и data-параметрами.


____________ЛОГИНАЦИЯ/РЕГИСТРАЦИЯ:
`app/Http/Controllers/HomeController.php`
`app/Http/Controllers/Auth/LoginController.php`

___________Есть реализация ролей Юзеров
Созданы доп.таблицы:
- php artisan make:migration create_roles_table --create=roles (для хранения имен ролей для Юзеров)
- php artisan make:migration create_permissions_table --create=permissions (для хранения имен прав для ролей для Юзеров)
- php artisan make:migration create_permissions_roles_table --create=permissions_roles (связующая таблица,по внешнему_ключу,между таблицами `permissions` и `roles`)
- php artisan make:migration create_users_roles_table --create=users_roles (связующая таблица,по внешнему_ключу,между таблицами `users` и `roles`)
        а теперь после того как выполнили пред.миграции делаем сами связующие ключи для 2-х вновь сщзданных таблиц, а именно для `permissions_roles` `users_roles` и,значит,добавляем в них соответствующие поля:
- php artisan make:migration add_foreign_key_to_table_users_roles --create=users_roles
- php artisan make:migration add_foreign_key_to_table_permissions_roles --create=permissions_roles

    Permissions:
        - VIEW_ADMIN_PANEL - право просматривать Гл.страницу панели Администратора
        - ADD_MATERIAL - право добавлять метериалы(Статьи, Портфолио, Меню, Слайдер)
        - UPDATE_MATERIAL - право обновлять(редактировать) метериалы(Статьи, Портфолио, Меню, Слайдер)
        - DELETE_MATERIAL - право удалять метериалы(Статьи, Портфолио, Меню, Слайдер)
        - ADD_USERS - право добавлять Юзеров в БД
        - UPDATE_USERS - право обновлять(редактировать) Юзеров
        - DELETE_USERS - право удалять(редактировать) Юзеров


______________________СОЗДАНИЕ своих ПОЛИТИК авторизированных действий(authorize policy)
1) `app/Http/Controllers/Admin/ArticleResourceController.php` в нужном методе, например ` public function create()` на создание новой статьи и сохранении ее в БД, пишем
        if( Gate::denies('create', AdminMainController::$_objArticle) ) { abort(404); } //Если у Юзеру запрещено право на создание(добавление) нового материала, то abort
            //или
        if( !Auth::user()->can('create', AdminMainController::$_objArticle) ) { abort(404); } //Если у Юзера нет прав на создание(добавление) нового материала, то abort
            //или
        $UserCanDoThis = Auth::user()->userCanDo( Auth::user()->id, array('VIEW_ADMIN_PANEL','ADD_MATERIAL'), true );
        if( !$UserCanDoThis ) { abort(404); } //если текущий Юзер не имеет соответсвующих прав на просмотр Гл.стр.Админ-панели,то редирект на 404,а лучше создать шаблон для ошибки прав доступа и рендерить его

2) Cоздаем свою новую authorize policy для модели `Article`:
php artisan make:policy ArticlePolicy
        (!)Если так прописать: php artisan make:policy ArticlePolicy --model=Article
                то автоматически создасться authorize policy с базовыми "CRUD" методами уже включенными в authorize policy ('view','create','update','delete')
Новая такая authorize policy создасться в новой папке(если ее не было до этого) `/app/Policies` и там наша authorize policy - `app/Policies/ArticlePolicy.php`
3) Теперь в `app/Policies/ArticlePolicy.php` находим или создаем метод с таким же именем как мы указали с своем Контроллере для проверки права, - а именно 'create' и в этом методе:
        public function create(User $user) {
            return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','ADD_MATERIAL'), false );
        }
        (!) метод `userCanDo()` это метод,который мы сами написали,для проверки определенного права(permission) для Юзера и он возвращ. FALSE/TRUE в завис.есть ли передаваймый permission у данного Юзера.
            метод `userCanDo()` описан в Модели User - см.`corporate.laravel.loc/app/User.php`

4) И нужно еще зарегистрировать наш созданный authorize policy `ArticlePolicy.php` для модели `Article` в `app/Providers/AuthServiceProvider.php`, прописав в
            protected $policies = [
                'App\Model' => 'App\Policies\ModelPolicy',
                Article::class => ArticlePolicy::class, //register authorize policy `ArticlePolicy` for model `Article`
            ];
    Не забыть в `app/Providers/AuthServiceProvider.php` дать доступы соответствующие,- т.е.:
            use App\Article;
            use App\Policies\ArticlePolicy;


____________________Установка расширения "Intervention Image" для работы (в частности тут для кропанья изображений):
Установлена дополнительная зависимость - пакет(расширение) "Intervention Image"(для работы с изображениями- мощный инструмент на основе PHP GD-library)
см. `/composer.json` line: "intervention/image": "2.*"
и см. `/config/app.php` в части массива 'providers' => [] и массива 'aliases' => []
Вся установка описана в `install_Laravel_INFO.php`