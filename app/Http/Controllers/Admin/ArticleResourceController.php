<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //OR: use Validator;
use Illuminate\Support\Facades\Config; //or: use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image; //"Intervention Image" library
use App\Article;

class ArticleResourceController extends AdminMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'backendsite.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.index`
        $this->_title= 'ADMIN-PANEL: Articles'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('view', AdminMainController::$_objArticle) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Articles (articles list)
        //OR: if( !Auth::user()->can('view', AdminMainController::$_objArticle) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Articles (articles list)

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_articles = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objArticle,false, false, array('users','articlesCategories'), array()
        ); //for Articles of Blog without Pagination

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._articles')
                        ->with( 'all_articles', $get_all_articles ); //Данные для Articles (with pagination); //Отрендеринная View

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function index()


    /** Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function show($id) {}

    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
    */
    public function create() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('create', AdminMainController::$_objArticle) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового материала, то abort
            //OR: if( !Auth::user()->can('create', AdminMainController::$_objArticle) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового материала, то abort

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_article_categories = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objArticleCategory,false, false, false, array()  //for Articles of Blog without Pagination
        );
            //Forming Categories(with sub-categories) of Article
        $get_all_article_categories = $get_all_article_categories->groupBy('parent_cat_id'); //Сгрупированные `ArticleCategory` по полю `parent_cat_id`,что дает представление о их иерархии - о том есть ли Категория родительского уровня или это sub-категория(дочерняя)
            //Data of All Users
        $get_all_users =  AdminMainController::$_objUser->get(['id','name'])->toArray();


        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._form_add_article')
                        ->with( 'article_categories', $get_all_article_categories ) //Данные для Categories of articles
                        ->with( 'all_users', $get_all_users ); //Данные для Users

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function create()


    /** Store a newly created resource in storage. 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $size_article_img = Config::get('settings.articles_img'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        //______________________________________________________________________________________________________________________________________________________

        if( $request->isMethod('post') ) {
            $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
                'article_alias_input' => 'required|unique:articles,alias|max:100|min:2', //обяз.для запол.поле | уникальн.зн-е для поля `alias` в таб.`articles` | максимальная длинна символов = 100 | мин.длинна символов = 2
                'article_title_input' => 'required|max:150|min:2',  //обязательное для заполнения поле | макс.длинна символов = 150 | мин.длинна символов = 2
                'article_text_input_ckeditor' => 'required|max:1500|min:20',  //обязательное для заполнения поле | максимальная длинна символов = 500 | минимальная длинна символов = 5
                'article_image_input' => 'required|image' //поле под проверкой должно быть успешно загруженным файлом //или `image`- загруженный файл должен быть изображением в формате jpeg,png,bmp,gif или svg.
            ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
            $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
                'required' => 'The `:attribute` field is required! +',
                'unique'  => 'The `:attribute` must be unique in table of DB `pages` in field `alias`',
                'article_alias_input.max' => 'The `:attribute` may not be greater than 100 characters! +',
                'article_alias_input.min' => 'The `:attribute` must be greater than 2 characters! +',
                'article_title_input.max' => 'The `:attribute` may not be greater than 150 characters! +',
                'article_title_input.min' => 'The `:attribute` must be greater than 2 characters! +',
                'article_text_input_ckeditor.max' => 'The `:attribute` may not be greater than 500 characters! +',
                'article_text_input_ckeditor.min' => 'The `:attribute` must be greater than 20 characters! +',
                'article_image_input' => 'The `:attribute` must be images +',
                /* если нужно установить текст для валидации для конкретно определенного поля,то тогда так:
                    'your_name.required'=>'The `:attribute` field is required - ONLY NAME!',
                    'your_name.max'=>'The `:attribute` field not be greater than 30 characters! - ONLY NAME!',
                    'your_email.required'=>'The `:attribute` field is required- ONLY EMAIL!',
                    'your_email.email'=>'The `:attribute` field is required- ONLY EMAIL!',   и т.д.
                */
            ];
            $validator = Validator::make( $request->all(), $rules, $messages );  //$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages);
            if( $validator->fails() ) { //IF VALIDATION FAILS:
                //dump( $validator->failed() );exit(); //для проверки(ОТЛАДКИ) провала валидации. Просмотреть,что в массиве метода провала валидации и какие поля и правила ее вызвали
                $request->flash(); //записываем в сессию flash()-данные (ошибки валидации и данные полей input предыдущего POST, чтобы потом была возможность их вернуть)
                //dd( $request->session()->all() ); //-прсмотреть,что пишется в Сессию

                /* Чтобы просматривать ошибки валидации. Эту же инфо мы выводим и во вью - `resources/views/backendsite/include/_form_add_article.blade.php`
                    $msg_errors = $validator->errors(); dump($msg_errors); dump( $msg_errors->all() );
                    dump( $msg_errors->first('page_new_name') ); - Просмотр ошибки для отдельно взятого поля(первая из ошибок,для данного поля, будет выводиться)
                    dump( $msg_errors->get('page_new_name') ); - Просмотр ошибки для отдельно взятого поля(все из имеющихся ошибок для отдельного поля будут выводиться)
                    if( $msg_errors->has('page_new_name') ){ dump( $msg_errors->get('page_new_name') ); } - Проверить есть ли ошибка(и) валидации для поля 'page_new_name' и тогда вывести их все
                */

                /* => Рендерим View */
                return redirect()->route('admin_articles_create')->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
            }
            else { //IF VALIDATION SUCCESS:
                $data_of_post = $request->except('_token','btn_submit_add_article');

                /* => Проверяем загружен ли файл и что там, кропаем(или resize) изображения нужных размеров и сохраняем загруженный файл на сервер в определ.директорию. А именно в `public/img/blog_images` */
                if( $request->hasFile('article_image_input') ) { //проверяем,имеем ли мы загруженный такой файл по своему ключу(имя поля в Форме для загрузки файла)
                    $file_info = $data_of_post['article_image_input'];  //dump($file_info);
                    $file_info_origin_name = $file_info->getClientOriginalName(); //dd($file_info_origin_name);
                    /* тоже самое можно получить и через `$request->file` -  объект специального Класса `UploadedFile`
                        $file_info = $request->file('article_image_input'); dump($file_info);
                        $file_info_origin_name = $file_info->getClientOriginalName();
                    */

                    if( $file_info->isValid() ) { //если загруженный файл валидный и все ОК, то

                        $articleImageNewObj = new \stdClass(); //создаем новый пустой Объект под формирование нужных вариантов кропнутых(или resize) изображений родительского изображения,загруженного на сервер
                        $articleImageNewObj->origin = str_random(5).'_origin.jpg'; //для изображения оригинального размера
                        $articleImageNewObj->max = str_random(5).'_max.jpg'; //для изображения максимального размера
                        $articleImageNewObj->mini = str_random(5).'_mini.jpg';   //для изображения минимального размера

                        $newImg = Image::make($file_info); //Получаем именно уже объект `Intervention Image` и,значит доступ ко всем его методам. (!)В PHP должно быть предварительно установлена `GD Library`-  sudo apt-get install php7.0-gd
                            //получаем,путем resize или crop входного изображения,изображения нужных размеров и сохраняем их у себя на сервере по пути "public_path().'/img/blog_images/'" и под нужным именем из Объекта $articleImageNewObj
                        $newImg->resize( $size_article_img['max']['width'], $size_article_img['max']['height'] ) //resize to 1280x960 pixel
                                ->save( public_path().'/img/blog_images/'.$articleImageNewObj->max );
                        $newImg->resize( $size_article_img['origin']['width'], $size_article_img['origin']['height'] ) //resize to 960x670 pixel
                                ->save( public_path().'/img/blog_images/'.$articleImageNewObj->origin);
                        $newImg->resize( $size_article_img['mini']['width'], $size_article_img['mini']['height'] ) //resize to 1280x960 pixel
                                ->save( public_path().'/img/blog_images/'.$articleImageNewObj->mini );
                            //формируем массив(JSON-формат) для всех вариаций изображений для сохраняемой статьи(article) для сохранения в БД(в БД таб.`articles` поле `images` у нас именно хранится информация в виде JSON-формата)
                        //$dataJsonImages = json_encode($articleImageNewObj);

                        $create_result = AdminMainController::$_objArticle->create([  //______INSERT
                            'alias' => $data_of_post['article_alias_input'],
                            'title' => $data_of_post['article_title_input'],
                            'desctext' => str_limit( strip_tags($data_of_post['article_text_input_ckeditor']), 350 ),
                            'fulltext' => $data_of_post['article_text_input_ckeditor'],
                            'user_id' => $data_of_post['article_user_select'],
                            'articles_category_id' => $data_of_post['article_category_select'],
                            'images' => json_encode($articleImageNewObj)
                        ]);
                        if( $create_result ){ //если данные успешно сохранены в таб.БД
                            $request->session()->flash('status', 'New Article has been successfully added'); //формируем flash-сообщение об успешном добавлении в БД,кот.будем выводить во View
                            /* => Рендерим View */
                            return redirect()->route('admin_articles');
                        }
                        /*OR:
                            $objectArticle = new Article([
                                'alias' => $data_of_post['article_alias_input'],
                                'title' => $data_of_post['article_title_input'],
                                'desctext' => str_limit( strip_tags($data_of_post['article_text_input_ckeditor']), 350 ),
                                'fulltext' => $data_of_post['article_text_input_ckeditor'],
                                'user_id' => $data_of_post['article_user_select'],
                                'articles_category_id' => $data_of_post['article_category_select'],
                                'images' => json_encode($articleImageNewObj)
                            ]);
                            if( $objectArticle->save() ){ //если данные успешно сохранены в таб.БД
                                $request->session()->flash('status', 'New Article has been successfully added'); //формируем flash-сообщение об успешном добавлении в БД,кот.будем выводить во View
                                return redirect()->route('admin_articles');
                            }
                        */
                    }

                }

            }

        }

    }  //__/public function store()


    /** Show the form for editing the specified resource.
     * @param  string  $alias - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_articles_edit',['alias'=>$i_article->alias]) в `resources/views/backendsite/include/_articles.blade.php`.
                                $alias это идентификатор редактируемой записи (вместо стандартного ID, т.к`alias` у нас для статьи уникальный)
     * @return \Illuminate\Http\Response
    */ /* Если прописать вот так:  public function edit(Article $article) ,то потом внутри метода нам не нужно получать данные из БД через: Article::find($id). Вся выборка по нужному идентификатору уже будет
          содержаться в $articles. Это можно просмотреть,если сразу прописать: dump($articles); Но двнные будут содердаться в JSON-формате, поэтому получать их через: $articles = json_decode($articles); dd($articles->alias);
        Но это именно,когда мы иммем дело с ID в качестве передаваемого параметра и идентификатором редактируемой страницы.Тут мы ушли от станд.пути и работаем с строчным идентификатором - алиасом - $alias */
    public function edit($alias) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('update', AdminMainController::$_objArticle) ) { abort(404); } //Если у Юзеру запрещено право на редактирование материала, то abort
        //OR: if( !Auth::user()->can('update', AdminMainController::$_objArticle) ) { abort(404); } //Если у Юзера нет прав на редактирование материала, то abort

        $alias = strip_tags($alias);
        if( !$alias  ){ abort(404); } //если нет GET-параметра запроса по какким-то причинам,- сразу выдаем страницу "404"

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_article_categories = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objArticleCategory,false, false, false, array()  //for Articles of Blog without Pagination
        );
            //Forming Categories(with sub-categories) of Article
        $get_all_article_categories = $get_all_article_categories->groupBy('parent_cat_id'); //Сгрупированные `ArticleCategory` по полю `parent_cat_id`,что дает представление о их иерархии - о том есть ли Категория родительского уровня или это sub-категория(дочерняя)
            //Data of All Users
        $get_all_users =  AdminMainController::$_objUser->get(['id','name'])->toArray();

        $currentArticleObject = AdminMainController::$_objArticle //$alias - обязат. GET-параметр запроса - идентификатор редактируемой записи
                                ->select(['id','alias','title','fulltext','images','created_at','user_id','articles_category_id'])
                                ->where('alias', '=', $alias)->get();
        //OR: AdminMainController::$_objArticle->get(['id','alias','title','fulltext','images','created_at','user_id','articles_category_id'])->where('alias', '=', $alias);


        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._form_edit_article')
                        ->with( 'article_categories', $get_all_article_categories ) //Данные для Categories of articles
                        ->with( 'all_users', $get_all_users ) //Данные для Users
                        ->with( 'current_article_data', $currentArticleObject->toArray() ); //Данные для редактируемой статьи(Article)

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    }  //__/public function edit()


    /** Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $alias - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_articles_edit',['alias'=>$i_article->alias]) в `resources/views/backendsite/include/_articles.blade.php`.
                                $alias это идентификатор редактируемой записи (вместо стандартного ID, т.к`alias` у нас для статьи уникальный)
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $alias) {
        $size_article_img = Config::get('settings.articles_img'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $currentArticleObject = AdminMainController::$_objArticle->where('alias', '=', $alias)->get(); //Получаем объект данной(текущей) Articles
        $currentArticleObjectImages = $currentArticleObject[0]->images; //текущие данные по изображениям для статьи (article)
        //______________________________________________________________________________________________________________________________________________________

        $alias = strip_tags($alias);
        if( !$alias ){ abort(404); } //если нет GET-параметр запроса по какким-то причинам,- сразу выдаем страницу "404"

        $thisIDArticle = AdminMainController::$_objArticle->select(['id'])->where('alias', '=', $alias)->get()[0]->id; //получаем ID данной редактируемой записи
        $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
            'article_alias_input' => 'required|max:100|min:2|unique:articles,alias,'.$thisIDArticle, //обяз.для запол.поле | максимальная длинна символов = 100 | мин.длинна символов = 2 | уникальн.зн-е для поля `alias` в таб.`articles`,КРОМЕ данного редактируемого
            'article_title_input' => 'required|max:150|min:2',  //обязательное для заполнения поле | макс.длинна символов = 150 | мин.длинна символов = 2
            'article_text_input_ckeditor' => 'required|max:1500|min:20',  //обязательное для заполнения поле | максимальная длинна символов = 500 | минимальная длинна символов = 5
        ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
        $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
            'required' => 'The `:attribute` field is required! +',
            'unique'  => 'The `:attribute` must be unique in table of DB `pages` in field `alias`',
            'article_alias_input.max' => 'The `:attribute` may not be greater than 100 characters! +',
            'article_alias_input.min' => 'The `:attribute` must be greater than 2 characters! +',
            'article_title_input.max' => 'The `:attribute` may not be greater than 150 characters! +',
            'article_title_input.min' => 'The `:attribute` must be greater than 2 characters! +',
            'article_text_input_ckeditor.max' => 'The `:attribute` may not be greater than 500 characters! +',
            'article_text_input_ckeditor.min' => 'The `:attribute` must be greater than 20 characters! +',
            /* если нужно установить текст для валидации для конкретно определенного поля,то тогда так:
                'your_name.required'=>'The `:attribute` field is required - ONLY NAME!',
                'your_name.max'=>'The `:attribute` field not be greater than 30 characters! - ONLY NAME!',
                'your_email.required'=>'The `:attribute` field is required- ONLY EMAIL!',
                'your_email.email'=>'The `:attribute` field is required- ONLY EMAIL!',   и т.д.
            */
        ];
        $validator = Validator::make( $request->all(), $rules, $messages );  //$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages);
        if( $validator->fails() ) { //IF VALIDATION FAILS:
            //dump( $validator->failed() );exit(); //для проверки(ОТЛАДКИ) провала валидации. Просмотреть,что в массиве метода провала валидации и какие поля и правила ее вызвали
            $request->flash(); //записываем в сессию flash()-данные (ошибки валидации и данные полей input предыдущего POST, чтобы потом была возможность их вернуть)
            //dd( $request->session()->all() ); //-прсмотреть,что пишется в Сессию

            /* Чтобы просматривать ошибки валидации. Эту же инфо мы выводим и во вью - `resources/views/backendsite/include/_form_add_article.blade.php`
                $msg_errors = $validator->errors(); dump($msg_errors); dump( $msg_errors->all() );
                dump( $msg_errors->first('page_new_name') ); - Просмотр ошибки для отдельно взятого поля(первая из ошибок,для данного поля, будет выводиться)
                dump( $msg_errors->get('page_new_name') ); - Просмотр ошибки для отдельно взятого поля(все из имеющихся ошибок для отдельного поля будут выводиться)
                if( $msg_errors->has('page_new_name') ){ dump( $msg_errors->get('page_new_name') ); } - Проверить есть ли ошибка(и) валидации для поля 'page_new_name' и тогда вывести их все
            */

            /* => Рендерим View */
            return redirect()->route('admin_articles_edit',['alias'=>$alias])->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
        }
        else { //IF VALIDATION SUCCESS:
            $data_of_post = $request->except('_token');

            /* => Проверяем загружен ли файл и что там, кропаем(или resize) изображения нужных размеров и сохраняем загруженный файл на сервер в определ.директорию. А именно в `public/img/blog_images` */
            if( $request->hasFile('article_image_input') ) { //проверяем,имеем ли мы загруженный такой файл по своему ключу(имя поля в Форме для загрузки файла)
                $file_info = $data_of_post['article_image_input'];  //dump($file_info);
                $file_info_origin_name = $file_info->getClientOriginalName(); //dd($file_info_origin_name);
                /* тоже самое можно получить и через `$request->file` -  объект специального Класса `UploadedFile`
                    $file_info = $request->file('article_image_input'); dump($file_info);
                    $file_info_origin_name = $file_info->getClientOriginalName();
                */

                if( $file_info->isValid() ) { //если загруженный файл валидный и все ОК, то
                    $articleImageNewObj = new \stdClass(); //создаем новый пустой Объект под формирование нужных вариантов кропнутых(или resize) изображений родительского изображения,загруженного на сервер
                    $articleImageNewObj->origin = str_random(5).'_origin.jpg'; //для изображения оригинального размера
                    $articleImageNewObj->max = str_random(5).'_max.jpg'; //для изображения максимального размера
                    $articleImageNewObj->mini = str_random(5).'_mini.jpg';   //для изображения минимального размера

                    $newImg = Image::make($file_info); //Получаем именно уже объект `Intervention Image` и,значит доступ ко всем его методам. (!)В PHP должно быть предварительно установлена `GD Library`-  sudo apt-get install php7.0-gd
                    //получаем,путем resize или crop входного изображения,изображения нужных размеров и сохраняем их у себя на сервере по пути "public_path().'/img/blog_images/'" и под нужным именем из Объекта $articleImageNewObj
                    $newImg->resize( $size_article_img['max']['width'], $size_article_img['max']['height'] ) //resize to 1280x960 pixel
                    ->save( public_path().'/img/blog_images/'.$articleImageNewObj->max );
                    $newImg->resize( $size_article_img['origin']['width'], $size_article_img['origin']['height'] ) //resize to 960x670 pixel
                    ->save( public_path().'/img/blog_images/'.$articleImageNewObj->origin);
                    $newImg->resize( $size_article_img['mini']['width'], $size_article_img['mini']['height'] ) //resize to 1280x960 pixel
                    ->save( public_path().'/img/blog_images/'.$articleImageNewObj->mini );
                    /* формируем массив(JSON-формат) для всех вариаций изображений для сохраняемой статьи(article) для сохранения в БД(в БД таб.`articles` поле `images` у нас именно хранится информация в виде JSON-формата) */
                    //$dataJsonImages = json_encode($articleImageNewObj);

                    $check_new_image = true; //наш условный фгаг для того,чтобы проверять загрузили ли новое изображение
                }

            }
            else { $check_new_image = false; } //наш условный фгаг для того,чтобы проверять загрузили ли новое изображение

            /* => Сохраняем данные отредактированной страницы в таб.БД `pages` */
            if( $check_new_image ) { //если загружено новое изображение, то при апдейте данных сохраняем и новое изображение, а с ним и кропнутые его варианты
                if( is_object($currentArticleObject) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем редактировать
                    $currentArticleObject[0]->alias = $data_of_post['article_alias_input'];
                    $currentArticleObject[0]->title = $data_of_post['article_title_input'];
                    $currentArticleObject[0]->desctext = str_limit( strip_tags($data_of_post['article_text_input_ckeditor']), 350 );
                    $currentArticleObject[0]->fulltext = $data_of_post['article_text_input_ckeditor'];
                    $currentArticleObject[0]->user_id = $data_of_post['article_user_select'];
                    $currentArticleObject[0]->articles_category_id = $data_of_post['article_category_select'];
                    $currentArticleObject[0]->images = json_encode($articleImageNewObj); //новые сформированные изображения и новые имена для них
                }
                if( $currentArticleObject[0]->save() ) { //если данные успешно сохранены в таб.`articles` БД
                    $request->session()->flash('status', 'This Article has been successfully updated'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                    /* => Рендерим View */
                    return redirect()->route('admin_articles');
                }
            }
            else { //если новое изображение Не загружено, то при апдейте данных сохраняем старые имена изображений
                if( is_object($currentArticleObject) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем редактировать
                    $currentArticleObject[0]->alias = $data_of_post['article_alias_input'];
                    $currentArticleObject[0]->title = $data_of_post['article_title_input'];
                    $currentArticleObject[0]->desctext = str_limit( strip_tags($data_of_post['article_text_input_ckeditor']), 350 );
                    $currentArticleObject[0]->fulltext = $data_of_post['article_text_input_ckeditor'];
                    $currentArticleObject[0]->user_id = $data_of_post['article_user_select'];
                    $currentArticleObject[0]->articles_category_id = $data_of_post['article_category_select'];
                    //$currentArticleObject[0]->images = $currentArticleObjectImages; //старые(те,что и были)  изображения
                }
                if( $currentArticleObject[0]->save() ) { //если данные успешно сохранены в таб.`articles` БД
                    $request->session()->flash('status', 'This Article has been successfully updated'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                    /* => Рендерим View */
                    return redirect()->route('admin_articles');
                }
            }
        }

    }  //__/public function update()


    /** Remove the specified resource from storage. С удалением конкретной статьи удаляем и все комментарии,привязанные к ней. Удалять может только Юзер с Permission `DELETE_MATERIAL` - а это admin,согласно
                                                    табл.`permissions_roles` и `roles`.
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $alias
     * @return \Illuminate\Http\Response
     */ /* Если прописать вот так:  public function destroy($article Article) ,то потом внутри метода нам не нужно получать данные из БД через: Article::find($id). Вся выборка по нужному идентификатору уже будет
          содержаться в $articles. Это можно просмотреть,если сразу прописать: dump($articles); Но двнные будут содердаться в JSON-формате, поэтому получать их через: $articles = json_decode($articles); dd($$articles->alias);
        Но это именно,когда мы иммем дело с ID в качестве передаваемого параметра и идентификатором редактируемой страницы.Тут мы ушли от станд.пути и работаем с строчным идентификатором - алиасом - $alias */
    public function destroy(Request $request, $alias) {

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('delete', AdminMainController::$_objArticle) ) { abort(404); } //Если у Юзеру запрещено право на удаление данного материала, то abort
        //OR: if( !Auth::user()->can('delete', AdminMainController::$_objArticle) ) { abort(404); } //Если у Юзера нет прав на удаление данного материала, то abort

        $currentArticleObject = AdminMainController::$_objArticle->where('alias', '=', $alias)->get(); //Получаем объект данной(текущей) Articles
        $currentArticleObjectWithComments = AdminMainController::get_entries_with_settings( AdminMainController::$_objArticle,false, false, array('comments'), array('alias', '=', $alias) );
        //dd($currentArticleObjectWithComments[0]->comments[0]);
        //______________________________________________________________________________________________________________________________________________________

        $alias = strip_tags($alias);
        if( !$alias ){ abort(404); } //если нет GET-параметр запроса по какким-то причинам,- сразу выдаем страницу "404"

        if( is_object( $currentArticleObjectWithComments[0] ) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем удалять
            if( count($currentArticleObjectWithComments[0]->comments) > 0 ) { //если есть какие-то привязанные комментарии у данной статьи
                foreach( $currentArticleObjectWithComments[0]->comments as $item_comment ) {
                    $item_comment->delete(); //удаляем комментарии данной статьи
                }
            }
            if( $currentArticleObject[0]->delete() ) { //если данные успешно удалены из таб.`articles` БД
                $request->session()->flash('status', 'This Article has been successfully deleted!'); //формируем flash-сообщение об успешном удалении в БД,кот.будем выводить во View
                /* => Рендерим View */
                return redirect()->route('admin_articles');
            }
        }
        /* OR (так более проще и более через Laravel,а не вручную):
                if( is_object( $currentArticleObject[0] ) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем удалять
                    $currentArticleObject[0]->comments()->delete(); //обращаемся через Ф-ю `comments()`(из `app/Article.php`)- связь табл.`articles` c табл.`comments` через таб.`permissions_roles` к связанным комментариям этой статьи и удаляем их

                    if( $currentArticleObject[0]->delete() ) { //если данные успешно удалены из таб.`articles` БД
                        $request->session()->flash('status', 'This Article has been successfully deleted!'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                        return redirect()->route('admin_articles');
                    }
                }
        */
    }  //__/public function destroy()

}  //__/ArticleResourceController
