<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioFilterResourceController extends AdminMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        //$this->_template_view_name = 'backendsite.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.index`
        //$this->_title= 'ADMIN-PANEL: Permissions'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */public function index() {}

    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */public function create() {}

    /** Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ public function store(Request $request) {}

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

} //__/
