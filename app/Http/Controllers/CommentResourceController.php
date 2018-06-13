<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response; //нам нужен именно фасад Response,т.к. мы вызываем его метод `json()` для ответа в виде json-строки и используем
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config; //or: use Config;
use Illuminate\Support\Facades\Validator; //OR: use Validator;

use App\Comment;

class CommentResourceController extends SiteMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        //$this->_template_view_name = 'frontendsite.'.env('THEME').'.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.pink.index`
        //$this->_bar_for_template_view = TRUE; //переопределяем св-во и это значит,что на View,котрое мы будем этим Контроллером рендерить есть сайт-бар

        //$this->_keywords = 'Blog Page, Corporate site, LITTUS'; //для хранения ключевых слов для мета-тегов страницы
        //$this->_meta_description = 'Blog Page description text ...'; //для хранения мета-данных(описание) для страницы
        //$this->_title= 'BLOG'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */ public function index() {}


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
    */ /** Через  AJAX !!! */
    public function store(Request $request) {
        //echo json_encode(['hello' => 'worllllld!']); exit; //тестовый ответ от сервера - это чтобы проверить,что мы с сервера и именно из этого метода получаем ответ на AJAX-запрос. Смотреть в NetWork браузера!
        /* if( $request->isMethod('post') ) {} делать тут,по-сути,не нужно,т.к. этот метод REST-системы REST-Контроллера и так отведен специально под POST-запрос и сохраненение данных в БД  и тут у нас AJAX */

        $data_of_post = $request->except('_token'); //$request->all() //данные,что в POST и пришли из AJAX(см.`public/js/main.js` раздел `#COMMENTS Block in SINGLE ARTICLE page`)
        //print_r($data_of_post); //Смотреть в NetWork браузера в вкладке `Response`

        /* Правила для валидации данных.Указываем имя поля Формы,кот.мы будем валидировать при отправке данных, как ключ массива, затем,как значение ключа массива,сами правила валидации,разделяемые вертикал.слешом */
        if( Auth::check() ) { //если Юзер аутентифицирован,то правила валидации формы будут:
            $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
                'comment_user_text' =>'required|min:5|max:255', //обязательное для заполнения поле | минимальная длинна символов = 5 | максимальная длинна символов = 255
            ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
        }
        else { //иначе правила валидации формы будут:
            $rules = [  //весь набор правил валидации тут- https://laravel.com/docs/5.5/validation#available-validation-rules
                'comment_user_name' => 'required|max:50',  //обязательное для заполнения поле | максимальная длинна символов = 50
                'comment_user_email' => 'required|email', //обязательное для заполнения поле | проверка на корректность шаблона e-mail
                'comment_user_site' => 'required|max:100',  //обязательное для заполнения поле | максимальная длинна символов = 100
                'comment_user_text' =>'required|min:5|max:255', //обязательное для заполнения поле | минимальная длинна символов = 5 | максимальная длинна символов = 255
            ]; //альтернативная запись вышеописанных правил: 'your_name' => ['required, 'max:30']
        }
        /* Или можно было все сделать в одном массиве $rules без обращения к проверке аутентифицирован ли Юзер,- `sometimes` или `nullable`.
           Например: 'user_site'=>'sometimes|required', - такое правило скажет,что валидировать поле `user_site` только если оно есть(существует) в Объекте Request.
           У нас,когда Юзер аутентифицирован,полей 'comment_user_name','comment_user_email','comment_user_site' - не будет в POST,а,значит и в объекте`Request` и,значит,мы могли сразу просто писать:
        $rules = [
                'comment_user_name' => 'sometimes|required|max:50',  //если это поле есть в POST | обязательное для заполнения поле | максимальная длинна символов = 50
                'comment_user_email' => 'sometimes|required|email', //если это поле есть в POST | обязательное для заполнения поле | проверка на корректность шаблона e-mail
                'comment_user_site' => 'sometimes|required|max:100', //если это поле есть в POST | обязательное для заполнения поле | максимальная длинна символов = 100
                'comment_user_text' =>'required|min:5|max:255', //обязательное для заполнения поле | минимальная длинна символов = 5 | максимальная длинна символов = 255
            ];
        */
        $messages = [  //сообщения у полей формы для Юзера,когда поле не прошло валидацию - это свои пользовательские сообщения
            'required' => 'The `:attribute` field is required! +',
            'comment_user_text.max' => 'The `:attribute` may not be greater than 255 characters! +',
            'comment_user_text.min'  => 'The `:attribute` must be greater than 5 characters! +',
            'email' => 'The `:attribute` mast be real & correct e-mail address! +',
            /* если нужно установить текст для валидации для конкретно определенного поля,то тогда так:
                'your_name.required'=>'The `:attribute` field is required - ONLY NAME!',
                'your_name.max'=>'The `:attribute` field not be greater than 30 characters! - ONLY NAME!',
                'your_email.required'=>'The `:attribute` field is required- ONLY EMAIL!',
                'your_email.email'=>'The `:attribute` field is required- ONLY EMAIL!',   и т.д.
            */
        ];
        $validator = Validator::make( $data_of_post, $rules, $messages );  //$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages);

        if( $validator->fails() ) { //IF VALIDATION FAILS:
            //dump( $validator->failed() );exit(); //для проверки(ОТЛАДКИ) провала валидации. Просмотреть,что в массиве метода провала валидации и какие поля и правила ее вызвали

            /* => Возвращаем через Объект Response в виде json-данных(которые и ожидает наш Ajax - `public/js/main.js` раздел `#COMMENTS Block in SINGLE ARTICLE page`) */
            return Response::json( ['error' => $validator->errors()->all()] ); //в виде ответа вернем строку JSON
        }
        else { //IF VALIDATION SUCCESS:
            //return Response::json( $data_of_post ); //в виде ответа вернем строку JSON - проверять что получаем.ИСПОЛЬЗОВАТЬ при BEBUG`e. Смотреть через `Network` браузера

            /* => Сохраняем данные комментария в таб.БД `comments` */
            if( Auth::check() ) { //если Юзер аутентифицирован
                $create_result = Comment::create([  //______INSERT
                    'text' => $data_of_post['comment_user_text'],
                    'name' => '',
                    'email' => '',
                    'site' => '',
                    'user_id' => $data_of_post['comment_user_id'],
                    'article_id' => $data_of_post['comment_article_id'],
                    'parent_comment_id' => $data_of_post['comment_parent_comment_id']
                ]);
                /* или вот так:
                $create_result = new Comment([
                    'text' => $data_of_post['comment_user_text'],
                    'name' => '',
                    'email' => '',
                    'site' => '',
                    'user_id' => $data_of_post['comment_user_id'],
                    'article_id' => $data_of_post['comment_article_id'],
                    'parent_comment_id' => $data_of_post['comment_parent_comment_id']
                ]); $create_result->save();
                */
                $currentUserInfo = array();
                $currentUserInfo['id'] = Auth::user()->id;
                $currentUserInfo['name'] = Auth::user()->name;
                $currentUserInfo['email'] = Auth::user()->email;
            }
            else {  //если Юзер НЕ аутентифицирован
                $create_result = Comment::create([  //______INSERT
                    'text' => $data_of_post['comment_user_text'],
                    'name' => $data_of_post['comment_user_name'],
                    'email' => $data_of_post['comment_user_email'],
                    'site' => $data_of_post['comment_user_site'],
                    'user_id' => $data_of_post['comment_user_id'],
                    'article_id' => $data_of_post['comment_article_id'],
                    'parent_comment_id' => $data_of_post['comment_parent_comment_id']
                ]);
            }
            /* или вот так:
                $create_result = new Comment([
                    'text' => $data_of_post['comment_user_text'],
                    'name' => $data_of_post['comment_user_name'],
                    'email' => $data_of_post['comment_user_email'],
                    'site' => $data_of_post['comment_user_site'],
                    'user_id' => $data_of_post['comment_user_id'],
                    'article_id' => $data_of_post['comment_article_id'],
                    'parent_comment_id' => $data_of_post['comment_parent_comment_id']
                ]); $create_result->save();
            */

            $dataforViewOneCommentAjax = array();
            $dataforViewOneCommentAjax['article_id'] = $data_of_post['comment_article_id'];
            $dataforViewOneCommentAjax['this_comment_text'] = $data_of_post['comment_user_text'];
            $dataforViewOneCommentAjax['comment_parent_comment_id'] = $data_of_post['comment_parent_comment_id'];
            $dataforViewOneCommentAjax['this_comment_id'] = '_temporarily';
            $dataforViewOneCommentAjax['parent_comment_id'] = 0;
            $dataforViewOneCommentAjax['user_name'] = ( Auth::user() ) ? Auth::user()->name : $data_of_post['comment_user_name'];
            $dataforViewOneCommentAjax['user_email'] = ( Auth::user() ) ? Auth::user()->email : $data_of_post['comment_user_email'];
            $dataforViewOneCommentAjax['if_user_is_login'] = ( Auth::user() ) ? true : false;
                //return Response::json($dataforViewOneCommentAjax); //- проверять что получаем.ИСПОЛЬЗОВАТЬ при BEBUG`e. Смотреть через `Network` браузера

            $viewOneCommentAjax = view('frontendsite.'.env('THEME').'.include.__comment_one_comment_ajax')
                ->with( 'dataforViewOneCommentAjax', $dataforViewOneCommentAjax )->render(); //Данные для одиночного(временного) отображения комментария только что добавленного Юзером,чтобы сразу ему его показать
            //Возвращаем отрендеринную View c данными для 1-го Комментария добавленого в данный момент Юзером, чтобы показать ему.Для этого создан спец.макет`__comment_one_comment_ajax`
            return Response::json( ['success'=>TRUE, 'viewOneCommentAjax'=>$viewOneCommentAjax, 'dataforViewOneCommentAjax'=>$dataforViewOneCommentAjax] );  //в виде ответа вернем строку JSON
        }

    } //__/ public function store()


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

}  //__/CommentResourceController
