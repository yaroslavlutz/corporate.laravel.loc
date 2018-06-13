<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; //or: use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexResourceController extends AdminMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'backendsite.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.index`
        $this->_title= 'ADMIN-PANEL'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)

        /*
        if( Gate::denies('VIEW_ADMIN_PANEL') ) {
            //abort(404); //abort(403); //Если текущий User не имеет permission c 'VIEW_ADMIN_PANEL' (право на просмотр Гл.стр.Админ-панели), то 403-error
        }
        */
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        $UserCanDoThis = Auth::user()->userCanDo( Auth::user()->id, 'VIEW_ADMIN_PANEL', false );  //array('VIEW_ADMIN_PANEL','ADD_USERS','ADD_MATERIAL')
        if( !$UserCanDoThis ) { abort(404); } //Если у Юзера нет прав на просмотр Гл.страницы Админ-панели, то abort

        //=> GET DATA(from DB) THROUGH the MODEL:

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._home'); //Отрендеринная View

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
     */ public function store(Request $request) {}

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


}  //__/class IndexResourceController
