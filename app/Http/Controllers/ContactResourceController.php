<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OrderShipped; //Класс "mailable" для отправки почты(создан нами)
use Illuminate\Support\Facades\Mail;//OR: use Mail;
use Illuminate\Support\Facades\Validator; //OR: use Validator;

class ContactResourceController extends SiteMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.pink.index`
        $this->_bar_for_template_view = FALSE; //переопределяем св-во и это значит,что у View,котрое мы будем этим Контроллером рендерить нет сайт-бара(хотя это можно не писать,т.к.по-умолч.- FALSE)

        $this->_keywords = 'Contacts Page, Corporate site, LITTUS'; //для хранения ключевых слов для мета-тегов страницы
        $this->_meta_description = 'Contacts Page description text ...'; //для хранения мета-данных(описание) для страницы
        $this->_title= 'CONTACTS'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
            /* (!) For this his page no data from DB */

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/frontendsite/pink/index.blade.php` - "content" для "CONTACTS" page
        $content_page = view('frontendsite.'.env('THEME').'.include._contacts');

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
     */ public function create() {}

    /** Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        if( $request->isMethod('post') ) {  //проверяем был ли отправлен запрос именно POST //OR: if( $request->method() == 'POST' ){..}

            /* Правила для валидации данных.Указываем имя поля Формы,кот.мы будем валидировать при отправке данных, как ключ массива, затем,как значение ключа массива,сами правила валидации,разделяемые вертикал.слешом */
            $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
                'your_name' => 'required|max:30',  //обязательное для заполнения поле | максимальная длинна символов = 30
                'your_email' => 'required|email', //обязательное для заполнения поле | проверка на корректность шаблона e-mail
                'your_comment' =>'required|min:20', //обязательное для заполнения поле | минимальнпя длинна символов = 20
            ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']

            $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
                'required' => 'The `:attribute` field is required! +',
                'max' => 'The `:attribute` may not be greater than 30 characters! +',
                'email' => 'The `:attribute` mast be real & correct e-mail address! +',
                'min'  => 'The `:attribute` must be greater than 20 characters! +'
                /* если нужно установить текст для валидации для конкретно определенного поля,то тогда так:
                    'your_name.required'=>'The `:attribute` field is required - ONLY NAME!',
                    'your_name.max'=>'The `:attribute` field not be greater than 30 characters! - ONLY NAME!',
                    'your_email.required'=>'The `:attribute` field is required- ONLY EMAIL!',
                    'your_email.email'=>'The `:attribute` field is required- ONLY EMAIL!',   и т.д.
                */
            ];
            $validator = Validator::make($request->all(), $rules, $messages);  //$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages);

            if( $validator->fails() ) { //IF VALIDATION FAILS:
                //dump( $validator->failed() );exit(); //для проверки(ОТЛАДКИ) провала валидации. Просмотреть,что в массиве метода провала валидации и какие поля и правила ее вызвали
                $request->flash(); //записываем в сессию flash()-данные (ошибки валидации и данные полей input предыдущего POST, чтобы потом была возможность их вернуть)
                //dd( $request->session()->all() ); //-прсмотреть,что пишется в Сессию

                /* Чтобы просматривать ошибки валидации. Эту же инфо мы выводим и во вью - `resources/views/frontendsite/pink/include/_contacts.blade.php`
                    $msg_errors = $validator->errors(); dump($msg_errors); dump( $msg_errors->all() );
                    dump( $msg_errors->first('your_email') ); - Просмотр ошибки для отдельно взятого поля(первая из ошибок,для данного поля, будет выводиться)
                    dump( $msg_errors->get('your_email') ); - Просмотр ошибки для отдельно взятого поля(все из имеющихся ошибок для отдельного поля будут выводиться)
                    if( $msg_errors->has('your_email') ){ dump( $msg_errors->get('your_email') ); } - Проверить есть ли ошибка(и) валидации для поля 'your_email' и тогда вывести их все
                */
                return redirect()->route('contacts')
                    ->withErrors($validator)->withInput($request->all()); //OR: withInput( $request->input() ) - also works
            }
            /*  //Validation with automatic redirection to View
                Validator::make($request->all(), $rules, $messages)->validate();
            */
            else { //IF VALIDATION SUCCESS:
                $data_of_post = $request->except('_token'); //$request->all()
                /* dump($data_of_post['your_name']); dump($data_of_post['your_email']); dump($data_of_post['your_comment']); */

                /* => Send E-mail to Admin */
                $mail_admin = 'littus@admin.gmail.com';
                $name_user = $request->your_name; //your_name - это имя параметра `name` в Форме отправки,который будет находиться в POST(ну и в $request разумеется )
                $email_user = $request->your_email; //your_email - это имя параметра `name` в Форме отправки,который будет находиться в POST(ну и в $request разумеется )
                $comment_user = $request->your_comment; //your_comment - это имя параметра `name` в Форме отправки,который будет находиться в POST(ну и в $request разумеется )

                Mail::to($mail_admin)->send( new OrderShipped($name_user, $email_user, $comment_user) ); //`OrderShipped` - наш созданный Класс-"mailable" в кот.мы рендерим непосредственно сам шаблрн письма и передаем в него данные
                $request->session()->flash('status_success_send_mail', 'The +++ letter was successfully sent. Thank you!'); //формируем flash-сообщение об успешно отправки письма,кот.будем выводить во View
                return redirect()->route('contacts');
            }
        } //__/if( $request->isMethod('post') )

        //return redirect()->route('contacts');

    } //__/public function store()


    /** Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function edit($id) {}

    /** Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function update(Request $request, $id) {}

    /** Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function destroy($id) {}

}  //__/ContactResourceController
