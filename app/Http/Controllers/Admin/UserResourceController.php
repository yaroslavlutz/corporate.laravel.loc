<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //OR: use Validator;
use Illuminate\Support\Facades\Config; //or: use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\User;

class UserResourceController extends AdminMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'backendsite.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.index`
        $this->_title= 'ADMIN-PANEL: Users'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('view', AdminMainController::$_objUser) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Users (Users list)
        //OR: if( !Auth::user()->can('view', AdminMainController::$_objUser) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Users (Users list)

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_users = AdminMainController::$_objUser->all()->load('roles'); //For Users with relation of Roles

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._users')
            ->with( 'all_users', $get_all_users ); //For Users with relation of Roles

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    }  //__/public function index()


    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
    */
    public function create() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('create', AdminMainController::$_objUser) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового User, то abort
        //OR: if( !Auth::user()->can('create', AdminMainController::$_objUser) ) { abort(404); } //Если Юзеру запрещено право на создание(добавление) нового User, то abort

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_roles = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objRole,false, false, false, array()  //Data of All Roles
        );

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._form_add_user')
            ->with( 'all_roles', $get_all_roles ); //Data of All Roles

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
                'user_name_input' => 'required|max:100|min:2', //обяз.для запол.поле | максимальная длинна символов = 100 | мин.длинна символов = 2
                'user_email_input' => 'required|email|max:255|unique:users,email',  //обязательное для заполнения поле | проверка на корректность шаблона e-mail |макс.длинна символов = 150 | мин.длинна символов = 2
                /* `confirmed`- зн-е поля должно совпадать с зн-ем поля с этим же именем плюс `_confirmation`.Т.е.если проверяется поле с именем "password",то др.поле для подтверждения пароля,должно иметь имя "password_confirmation" */
                'password' => 'required|min:6|confirmed', //обязательное для заполнения поле | минимальная длинна символов = 6 | есть поле для подтверждения
                'password_confirmation'=> 'required', //обяз.для запол.поле
            ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
            $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
                'required' => 'The `:attribute` field is required! +',
                'unique' => 'The `:attribute` must be unique in table of DB `users` in field `email`',
                'email' => 'The `:attribute` mast be real & correct e-mail address! +',
                'user_name_input.max' => 'The `:attribute` may not be greater than 100 characters! +',
                'user_name_input.min' => 'The `:attribute` must be greater than 2 characters! +',
                'user_email_input.max' => 'The `:attribute` may not be greater than 255 characters! +',
                'confirmed' => 'password confirmed incorrect!',
                /* если нужно установить текст для валидации для конкретно определенного поля,то тогда так:
                    'your_name.required'=>'The `:attribute` field is required - ONLY NAME!',
                    'your_name.max'=>'The `:attribute` field not be greater than 30 characters! - ONLY NAME!',
                    'your_email.required'=>'The `:attribute` field is required- ONLY EMAIL!',
                    'your_email.email'=>'The `:attribute` field is required- ONLY EMAIL!',   и т.д.
                */
            ];
            $validator = Validator::make($request->all(), $rules, $messages);  //$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages);
            if ($validator->fails()) { //IF VALIDATION FAILS:
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
                return redirect()->route('admin_users_create')->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
            } else { //IF VALIDATION SUCCESS:
                $data_of_post = $request->except('_token','btn_submit_add_user_item');

                $create_new_user = AdminMainController::$_objUser->create([  //______INSERT
                    'name' => $data_of_post['user_name_input'],
                    'email' => $data_of_post['user_email_input'],
                    'password' => bcrypt($data_of_post['password'])
                    /* OR:
                        $create_new_user = new User([
                            'name' => $data_of_post['user_name_input'],
                            'email' => $data_of_post['user_email_input'],
                            'password' => bcrypt($data_of_post['password'])
                        ]);
                        if( $create_new_user->save() ) {} //если данные успешно сохранены в таб.БД
                    */
                ]);
                if( $create_new_user ){ //если данные успешно сохранены в таб.БД
                    /* Привязываем к только что добавленной Модели User`a указанную для него Роль(ID роли).Эта роль по ее ID вместе с ID новодобавленного User`a запишутся в таб.`users_roles`
                    $cnt = count($data_of_post['role_id']);
                    for( $i=0; $i < $cnt; $i++ ){
                        $create_new_user->roles()->attach( $data_of_post['role_id'][$i] );
                    } //$create_new_user->roles()->attach( $data_of_post['role_id'][0] ); - если для только одного зн-я
                    */
                //или вот так,если подразумевается,что будет(может быть) не одно зн-е роли для Юзера,а несколько в массиве и мы можем всем массивом(где содержаться ID нужных ролей) передать их и привязать к Юзеру:
                    /* sync() - реализует синхронизацию(привязку) связанных Моделей через связующую таблицу(в данном случае через таб.`users_roles`) в соответствии со списком идентификаторов.
                    Т.е. именно в $data_of_post['role_id'] содержится массив(список) идентификаторов для определенного User`a. Так,в табл.БД `users_roles` в поле `role_id` находятся идентификаторы для
                    определенного User`a, а в поле `user_id` находится идентификатор самого User`a,к которому и относятся идентификаторы роли(ролей)(поле `role_id`)
                    */
                    $create_new_user->roles()->sync( $data_of_post['role_id'] ); //сохраняем информацию о ролях для этого Юзера

                    $request->session()->flash('status', 'New User has been successfully added'); //формируем flash-сообщение об успешном добавлении в БД,кот.будем выводить во View
                    /* => Рендерим View */
                    return redirect()->route('admin_users');
                }
            }
        }

    } //__/public function store()


    /** Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function show($id) {}


    /** Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     * @param $id int - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_users_edit',['id'=>$i_user->id]) в `resources/views/backendsite/include/_users.blade.php`.
                        $id это идентификатор редактируемой записи.
     */ /* Если прописать вот так:  public function edit(User $user) ,то потом внутри метода нам не нужно получать данные из БД через: User::find($id). Вся выборка по нужному идентификатору уже будет
          содержаться в $user. Это можно просмотреть,если сразу прописать: dump($user); Но двнные будут содердаться в JSON-формате, поэтому получать их через: $articles = json_decode($user); dd($user->id);
       */
    public function edit($id) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('update', AdminMainController::$_objUser) ) { abort(404); } //Если у Юзеру запрещено право на редактирование материала, то abort
        //OR: if( !Auth::user()->can('update', AdminMainController::$_objUser) ) { abort(404); } //Если у Юзера нет прав на редактирование материала, то abort

        $id = strip_tags($id);
        if( !$id  ){ abort(404); } //если нет GET-параметра запроса по какким-то причинам,- сразу выдаем страницу "404"

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_roles = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objRole,false, false, false, array()  //Data of All Roles
        );

        $currentUserObject = AdminMainController::$_objUser //$id - обязат. GET-параметр запроса - идентификатор редактируемой записи
            ->select(['id','name','email','password'])
            ->where('id', '=', $id)->get()->load('roles'); //For User with relation of Roles
        //OR: AdminMainController::$_objUser->get(['id','name','email','password'])->where('id', '=', $id)->load('roles');

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._form_edit_user')
            ->with( 'current_user', $currentUserObject ) //For User with relation of Roles
            ->with( 'all_roles', $get_all_roles ); //For User with relation of Roles

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function edit()


    /** Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_users_update',['id'=>$current_user[0]->id]) в `resources/views/backendsite/include/_form_edit_user.blade.php`.
                          $id это идентификатор редактируемой записи.
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $id = strip_tags($id);
        if( !$id  ){ abort(404); } //если нет GET-параметра запроса по какким-то причинам,- сразу выдаем страницу "404"
        $currentUserObject = AdminMainController::$_objUser->where('id', '=', $id)->get(); //Получаем объект данной(текущей) модели User
        //_____________________________________________________________________________________________________________________________________

        $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
            'user_name_input' => 'required|max:100|min:2', //обяз.для запол.поле | максимальная длинна символов = 100 | мин.длинна символов = 2
            'user_email_input' => 'required|email|max:255|unique:users,email,'.$currentUserObject[0]->id,  //обязательное для заполнения поле | проверка на корректность шаблона e-mail | макс.длинна символов = 255 | уникальн.зн-е для поля `email` в таб.`users`,КРОМЕ данного редактируемого
            /* `confirmed`- зн-е поля должно совпадать с зн-ем поля с этим же именем плюс `_confirmation`.Т.е.если проверяется поле с именем "password",то др.поле для подтверждения пароля,должно иметь имя "password_confirmation" */
            'password' => 'nullable|min:6|confirmed', //может быть вовсе не заполненным,но если что-то введено,то делать валидацию по указанным далее правилам | минимальная длинна символов = 6 | есть поле для подтверждения
        ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
        $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
            'required' => 'The `:attribute` field is required! +',
            'unique' => 'The `:attribute` must be unique in table of DB `users` in field `email`',
            'email' => 'The `:attribute` mast be real & correct e-mail address! +',
            'user_name_input.max' => 'The `:attribute` may not be greater than 100 characters! +',
            'user_name_input.min' => 'The `:attribute` must be greater than 2 characters! +',
            'user_email_input.max' => 'The `:attribute` may not be greater than 255 characters! +',
            'confirmed' => 'password confirmed incorrect!',
            /* если нужно установить текст для валидации для конкретно определенного поля,то тогда так:
                'your_name.required'=>'The `:attribute` field is required - ONLY NAME!',
                'your_name.max'=>'The `:attribute` field not be greater than 30 characters! - ONLY NAME!',
                'your_email.required'=>'The `:attribute` field is required- ONLY EMAIL!',
                'your_email.email'=>'The `:attribute` field is required- ONLY EMAIL!',   и т.д.
            */
        ];
        $validator = Validator::make($request->all(), $rules, $messages);  //$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages);
        if ($validator->fails()) { //IF VALIDATION FAILS:
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
            return redirect()->route('admin_users_edit',['id'=>$id])->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
        } else { //IF VALIDATION SUCCESS:
            $data_of_post = $request->except('_token', 'btn_submit_edit_user_item');

            if( is_object($currentUserObject) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем редактировать
                $currentUserObject[0]->name = $data_of_post['user_name_input'];
                $currentUserObject[0]->email = $data_of_post['user_email_input'];
                //если в $data_of_post['password'] не NULL,значит в это поле что-то введено и нужно пересохранять новый введенный пароль,в противном случае мы с паролем ничего не делаем и остантся он прежним
                if( $data_of_post['password'] !== NULL) {
                    $currentUserObject[0]->password = bcrypt($data_of_post['password']);
                }
            }
            if( $currentUserObject[0]->save() ) { //если данные успешно сохранены в таб.`users` БД
                //или вот так,если подразумевается,что будет(может быть) не одно зн-е роли для Юзера,а несколько в массиве и мы можем всем массивом(где содержаться ID нужных ролей) передать их и привязать к Юзеру:
                /* sync() - реализует синхронизацию(привязку) связанных Моделей через связующую таблицу(в данном случае через таб.`users_roles`) в соответствии со списком идентификаторов.
                Т.е. именно в $data_of_post['role_id'] содержится массив(список) идентификаторов для определенного User`a. Так,в табл.БД `users_roles` в поле `role_id` находятся идентификаторы для
                определенного User`a, а в поле `user_id` находится идентификатор самого User`a,к которому и относятся идентификаторы роли(ролей)(поле `role_id`)
                */
                $currentUserObject[0]->roles()->sync( $data_of_post['role_id'] ); //сохраняем информацию о ролях для этого Юзера

                $request->session()->flash('status', 'This User has been successfully updated'); //формируем flash-сообщение об успешном редактировании в БД,кот.будем выводить во View
                /* => Рендерим View */
                return redirect()->route('admin_users');
            }
        }

    } //__/public function update()


    /** Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id - обязат. GET-параметр запроса,указанный в роуте для этого Метода - route('admin_users_update',['id'=>$current_user[0]->id]) в `resources/views/backendsite/include/_form_edit_user.blade.php`.
                         $id это идентификатор редактируемой записи.
     * @return \Illuminate\Http\Response
    */ /* Если прописать вот так:  public function edit(User $user) ,то потом внутри метода нам не нужно получать данные из БД через: User::find($id). Вся выборка по нужному идентификатору уже будет
          содержаться в $user. Это можно просмотреть,если сразу прописать: dump($user); Но двнные будут содердаться в JSON-формате, поэтому получать их через: $articles = json_decode($user); dd($user->id);
       */
    public function destroy(Request $request, $id) {
        $id = strip_tags($id);
        if( !$id  ){ abort(404); } //если нет GET-параметра запроса по какким-то причинам,- сразу выдаем страницу "404"
        $currentUserObject = AdminMainController::$_objUser->where('id', '=', $id)->get(); //Получаем объект данной(текущей) модели User
        //_____________________________________________________________________________________________________________________________________

        if( is_object( $currentUserObject[0] ) ) {  //проверяем Объект ли у нас пришел,т.е. найдена ли запись(которую мы имеем как Объект),которую мы будем удалять
            /* `detach()`- реализует отвязку(удаление) связанных Моделей через связующую таблицу(в данном случае через таб.`users_roles`) в соответствии со списком идентификаторов. Метод полностью противоположный `sync()`
                Т.е. именно в $data_of_post['role_id'] содержится массив(список) идентификаторов для определенного User`a. Так,в табл.БД `users_roles` в поле `role_id` находятся идентификаторы для
                определенного User`a, а в поле `user_id` находится идентификатор самого User`a,к которому и относятся идентификаторы роли(ролей)(поле `role_id`) */
            $currentUserObject[0]->roles()->detach();

            if( $currentUserObject[0]->delete() ) { //если данные успешно удалены из таб.`articles` БД
                $request->session()->flash('status', 'User has been successfully deleted!'); //формируем flash-сообщение об успешном удалении в БД,кот.будем выводить во View
                /* => Рендерим View */
                return redirect()->route('admin_users');
            }
        }
    }  //__/public function destroy()

} //__/UserResourceController
