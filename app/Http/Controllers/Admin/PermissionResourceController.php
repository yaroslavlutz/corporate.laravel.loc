<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //OR: use Validator;
use Illuminate\Support\Facades\Config; //or: use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PermissionResourceController extends AdminMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'backendsite.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.index`
        $this->_title= 'ADMIN-PANEL: Permissions'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
   */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('view', AdminMainController::$_objPermission) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Articles (articles list)
        //OR: if( !Auth::user()->can('create', AdminMainController::$_objPermission) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Articles (articles list)


        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_roles = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objRole,array('id','name'), false, false, array()  //for Roles without Pagination
        );
        $get_all_permissions = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objPermission,array('id','name'), false, false, array()  //for Permissions without Pagination
        );

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/backendsite/index.blade.php` - "content" для "HOME" page
        $content_page = view('backendsite.include._permissions')
            ->with( 'all_roles', $get_all_roles )  //for Roles
            ->with( 'all_permissions', $get_all_permissions ); //for Permissions

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function index()


    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
    */public function create() {}


    /** Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        //=> IF CURRENT USER CAN DO THIS:
        if( Gate::denies('update', AdminMainController::$_objPermission) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Articles (articles list)
        //OR: if( !Auth::user()->can('update', AdminMainController::$_objPermission) ) { abort(404); } //Если Юзеру запрещено право на просмотр страницы с Articles (articles list)
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_all_roles = AdminMainController::get_entries_with_settings(
            AdminMainController::$_objRole,array('id','name'), false, false, array()  //for all Roles
        );

        if( $request->isMethod('post') ) {
            /* Данные,кот.получаются в POST построены т.о.что в качестве `ключа` массива выступает идентификатор Роли(Role),в качестве зн-я этого `ключа` - идентификатор конкретной привилегии(Permission),
              которая привязана к конкретной Роли(Role) */
            $data_of_post = $request->except('_token', 'btn_submit_change_permissions');

            foreach( $get_all_roles as $item_role ) {
                if( isset($data_of_post[$item_role->id]) ) { //если существует в массиве данных POST($data_of_post) ячейка,номер которой совпадает с перебираемыми в этом цикле ролями,значит для такой роли есть данные для обновления из $data_of_post
                    $item_role->savePermissions( $data_of_post[$item_role->id] ); //метод для сохранения привилегий в БД для определенной Роли,описанный в model `Role`
                }
                else {
                    $item_role->savePermissions([]); //значит для такой роли нет данных из $data_of_post для обновления и мы передаем в Ф-ю `savePermissions()` пустой массив
                }
            }
            $request->session()->flash('status', 'Permissions has been changed! '); //формируем flash-сообщение об успешном обновлении(изменении) данных по Permissions для определенной роли
            /* => Рендерим View */
            return redirect()->route('admin_permissions');
        }

    } //__/public function store()


    /** Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */ public function show($id) {}

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

} //__/PermissionResourceController
