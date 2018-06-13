<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //OR: use Validator;
use Illuminate\Support\Facades\Config; //or: use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MenuResourceController extends AdminMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'backendsite.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.index`
        $this->_title= 'ADMIN-PANEL: Menus'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //______________________________________________________________________________________________________________________________________________________

    /** Forming Items Menu(parent Item Menu with sub-Item menu if it exists) for frontend-part
     *  @return  array
    */
    protected static function forming_items_menu() {
        $result_menu = AdminMainController::$_objMenu->get_all_menu();
        $parent_menu_items = array();
        $child_menu_items = array();

        for( $i=0, $cnt=count($result_menu)  ; $i < $cnt; ++$i ) {
            if( $result_menu[$i]['parent_menu_id'] == 0 ) {  //если это родительский пункт Меню. У такового ['parent_menu_id'] == 0
                $parent_menu_items[] = $result_menu[$i];
            }
            else { //если дочерний пункт меню. У такового ['parent_menu_id'] !== 0
                $child_menu_items[] = $result_menu[$i];
            }
        } //_endfor

        //$result_menu = array();
        //$result_menu['parent'] = $parent_menu_items;
        //$result_menu['child'] = $child_menu_items;

        for( $k=0,$cnt=count($parent_menu_items); $k<$cnt; ++$k ){ //level#1
            for( $k2=0,$cnt2=count($child_menu_items); $k2<$cnt2; ++$k2 ){ //level#2
                if( in_array( ($parent_menu_items[$k]['id']), $child_menu_items[$k2]) ) {
                    $parent_menu_items[$k]['submenu'][] = ($child_menu_items[$k2]);
                }//end level#2
            }//end level#1
        }
        $result_menu = array(); //очищаем массив для нового содержимого
        return $result_menu = $parent_menu_items;
    }  //__/protected function forming_nav_menu()
    //______________________________________________________________________________________________________________________________________________________


    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('view', AdminMainController::$_objMenu) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Menu (menu list)
        //OR: if( !Auth::user()->can('view', AdminMainController::$_objMenu) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с  Menu (menu list)

        //=> GET DATA(from DB) THROUGH the MODEL:
            //Формируем массив с меню из БД,где родительс.пункты меню и,если у них есть подпункты(дочерние),то они идут в родител.пункте подмассивом. Функционал аналогичен и взят из `app/Http/Controllers/SiteMainController.php` метод `forming_nav_menu()`
        $result_menu = self::forming_items_menu();

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._menus')
            ->with( 'all_menus', $result_menu ); //Данные для Menus

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function index()


    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
    */
    public function create() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('create', AdminMainController::$_objMenu) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового материала, то abort
        //OR: if( !Auth::user()->can('create', AdminMainController::$_objMenu) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового материала, то abort

        //=> GET DATA(from DB) THROUGH the MODEL:
        //Формируем массив с меню из БД,где родительс.пункты меню и,если у них есть подпункты(дочерние),то они идут в родител.пункте подмассивом. Функционал аналогичен и взят из `app/Http/Controllers/SiteMainController.php` метод `forming_nav_menu()`
        $result_menu = self::forming_items_menu();

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._form_add_menu')
            ->with( 'all_menus', $result_menu ); //Данные для Menus

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function create()


    /** Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        if( $request->isMethod('post') ) {
            $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
                'menu_title_input' => 'required|max:150|min:3',  //обязательное для заполнения поле | макс.длинна символов = 150 | мин.длинна символов = 3
                'menu_urlpath_input' => 'required|max:150|min:4',  //обязательное для заполнения поле | макс.длинна символов = 150 | мин.длинна символов = 4
            ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
            $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
                'required' => 'The `:attribute` field is required! +',
                'menu_title_input.max' => 'The `:attribute` may not be greater than 150 characters! +',
                'menu_title_input.min' => 'The `:attribute` must be greater than 3 characters! +',
                'menu_urlpath_input.max' => 'The `:attribute` may not be greater than 150 characters! +',
                'menu_urlpath_input.min' => 'The `:attribute` must be greater than 4 characters! +',
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
                return redirect()->route('admin_menus_create')->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
            }
            else { //IF VALIDATION SUCCESS:
                $data_of_post = $request->except('_token', 'btn_submit_add_menu_item');  //dd($data_of_post);

                $create_result = AdminMainController::$_objMenu->create([  //______INSERT
                    'title' => $data_of_post['menu_title_input'],
                    'url_path' => $data_of_post['menu_urlpath_input'],
                    'parent_menu_id' => $data_of_post['select_nesting_menu_item']
                ]);
                if( $create_result ){ //если данные успешно сохранены в таб.БД
                    $request->session()->flash('status', 'New Menu Item has been successfully added'); //формируем flash-сообщение об успешном добавлении в БД,кот.будем выводить во View
                    /* => Рендерим View */
                    return redirect()->route('admin_menus');
                }
                /*OR:
                    $objectMenu = new Menu([
                        'title' => $data_of_post['menu_title_input'],
                        'url_path' => $data_of_post['menu_urlpath_input'],
                        'parent_menu_id' => $data_of_post['select_nesting_menu_item']
                    ]);
                    if( $objectMenu->save() ){ //если данные успешно сохранены в таб.БД
                        $request->session()->flash('status', 'New Menu Item has been successfully added'); //формируем flash-сообщение об успешном добавлении в БД,кот.будем выводить во View
                        return redirect()->route('admin_menus');
                    }
                */
            }
        }

    } //__/public function store()


    /** Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function show($id) {}

    /** Show the form for editing the specified resource.
     * @param  int  $menu - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_menus_edit',['menu'=>$i_submenu['id']] в `resources/views/backendsite/include/_menus.blade.php`.
                            $menu это идентификатор редактируемой записи (вместо стандартного ID). В $menu приходит ID конкретной редактируемой записи
     * @return \Illuminate\Http\Response
    */ /* Если прописать вот так:  public function edit(Menu $menu) ,то потом внутри метода нам не нужно получать данные из БД через: Article::find($id). Вся выборка по нужному идентификатору уже будет
          содержаться в $menu. Это можно просмотреть,если сразу прописать: dump($menu); Но двнные будут содердаться в JSON-формате, поэтому получать их через: $articles = json_decode($menu); dd($menu->id);
        Но это именно,когда мы иммем дело с ID в качестве передаваемого параметра и идентификатором редактируемой страницы.Тут мы ушли от станд.пути и работаем с идентификатором - $menu */
    public function edit( $menu ) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('update', AdminMainController::$_objMenu) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового материала, то abort
        //OR: if( !Auth::user()->can('update', AdminMainController::$_objMenu) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового материала, то abort

        $menu = strip_tags($menu);
        if( !$menu ){ abort(404); } //если нет GET-параметра запроса по какким-то причинам,- сразу выдаем страницу "404"

        //=> GET DATA(from DB) THROUGH the MODEL:
        $current_menu = AdminMainController::$_objMenu->find($menu); //получаем данные текущей Модели по ID для ее редактирования
            //Формируем массив с меню из БД,где родительс.пункты меню и,если у них есть подпункты(дочерние),то они идут в родител.пункте подмассивом. Функционал аналогичен и взят из `app/Http/Controllers/SiteMainController.php` метод `forming_nav_menu()`
        $result_menu = self::forming_items_menu();

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._form_edit_menu')
            ->with( 'current_menu', $current_menu ) //Данные текущей Модели по ID для ее редактирования
            ->with( 'result_menu', $result_menu ); //Данные для Menus

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function edit()


    /** Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu) {
        $currentMenuObject = AdminMainController::$_objMenu->find($menu); //Получаем объект данной(текущей) Menu
        //______________________________________________________________________________________________________________________________________________________
        $menu = strip_tags($menu);
        if( !$menu ){ abort(404); } //если нет GET-параметр запроса по какким-то причинам,- сразу выдаем страницу "404"

        $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
            'menu_title_input' => 'required|max:150|min:3',  //обязательное для заполнения поле | макс.длинна символов = 150 | мин.длинна символов = 3
            'menu_urlpath_input' => 'required|max:150|min:4',  //обязательное для заполнения поле | макс.длинна символов = 150 | мин.длинна символов = 4
        ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
        $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
            'required' => 'The `:attribute` field is required! +',
            'menu_title_input.max' => 'The `:attribute` may not be greater than 150 characters! +',
            'menu_title_input.min' => 'The `:attribute` must be greater than 3 characters! +',
            'menu_urlpath_input.max' => 'The `:attribute` may not be greater than 150 characters! +',
            'menu_urlpath_input.min' => 'The `:attribute` must be greater than 4 characters! +',
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
            return redirect()->route('admin_menus_edit',['menu'=>$menu])->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
        }
        else {  //IF VALIDATION SUCCESS:
            $data_of_post = $request->except('_token', 'btn_submit_update_menu');

            if( is_object($currentMenuObject) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем редактировать
                $currentMenuObject->title = $data_of_post['menu_title_input'];
                $currentMenuObject->url_path = $data_of_post['menu_urlpath_input'];
                $currentMenuObject->parent_menu_id = $data_of_post['select_nesting_menu_item'];
            }
            if( $currentMenuObject->save() ) { //если данные успешно сохранены в таб.`menus` БД
                $request->session()->flash('status', 'This Menu has been successfully updated'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                /* => Рендерим View */
                return redirect()->route('admin_menus');
            }
        }

    } //__/public function update()


    /** Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $menu - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_menus_edit',['menu'=>$i_submenu['id']] в `resources/views/backendsite/include/_menus.blade.php`.
                            $menu это идентификатор редактируемой записи (вместо стандартного ID). В $menu приходит ID конкретной редактируемой записи
     * @return \Illuminate\Http\Response
    */ /* Если прописать вот так:  public function destroy(Menu $menu) ,то потом внутри метода нам не нужно получать данные из БД через: Article::find($id). Вся выборка по нужному идентификатору уже будет
          содержаться в $menu. Это можно просмотреть,если сразу прописать: dump($menu); Но двнные будут содердаться в JSON-формате, поэтому получать их через: $articles = json_decode($menu); dd($menu->id);
        Но это именно,когда мы иммем дело с ID в качестве передаваемого параметра и идентификатором редактируемой страницы.Тут мы ушли от станд.пути и работаем с идентификатором - $menu */
    public function destroy(Request $request, $menu) {
        $currentMenuObject = AdminMainController::$_objMenu->find($menu); //Получаем объект данной(текущей) Menu
        //______________________________________________________________________________________________________________________________________________________
        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('delete', AdminMainController::$_objMenu) ) { abort(404); } //Если у Юзеру запрещено право на удаление данного материала, то abort
        //OR: if( !Auth::user()->can('delete', AdminMainController::$_objMenu) ) { abort(404); } ///Если у Юзеру запрещено право на удаление данного материала, то abort

        $menu = strip_tags($menu);
        if( !$menu ){ abort(404); } //если нет GET-параметр запроса по какким-то причинам,- сразу выдаем страницу "404"

        if( is_object($currentMenuObject) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем удалять

            if( $currentMenuObject->parent_menu_id != 0 ) { //значит мы собираемся удалить дочерний пункт Меню(пункт меню принадлежащий родителю),- тогда мы просто удаляем его
                if( $currentMenuObject->delete() ) { //если данные успешно удалены из таб.`menus` БД
                    $request->session()->flash('status', 'Menu Item has been successfully deleted!'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                    /* => Рендерим View */
                    return redirect()->route('admin_menus');
                }
            }
            else {  //значит мы собираемся удалить родительский пункт Меню,а у него в свою очередь могут быть дочерние пункты,а это значит,что нужно удалить и их
                $sub_items_menus = AdminMainController::$_objMenu->where('parent_menu_id', '=', $currentMenuObject->id)->get(); //выбираем все подпункты(дочерние пункты) тукущего пункта меню,который будем удалять
                if( count($sub_items_menus) > 0 ){ //если они вообще есть у этого родительского пункта Меню,который мы собираемся удалять, то удаляем эти дочерние пункты Меню
                    foreach( $sub_items_menus as $sub_item_menu ) {
                        $sub_item_menu->delete();
                    }
                }
                if( $currentMenuObject->delete() ) { //если данные успешно удалены из таб.`menus` БД
                    $request->session()->flash('status', 'Menu Item has been successfully deleted!'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                    /* => Рендерим View */
                    return redirect()->route('admin_menus');
                }
            }
        }

    }  //__/public function destroy()

} //__/MenuResourceController
