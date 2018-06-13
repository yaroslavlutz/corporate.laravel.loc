<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; //or: use Config;

use App\PortfolioFilter;

class PortfolioResourceController extends SiteMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.pink.index`
        $this->_bar_for_template_view = FALSE; //переопределяем св-во и это значит,что у View,котрое мы будем этим Контроллером рендерить нет сайт-бара(хотя это можно не писать,т.к.по-умолч.- FALSE)

        $this->_keywords = 'Portfolio Page, Corporate site, LITTUS'; //для хранения ключевых слов для мета-тегов страницы
        $this->_meta_description = 'Portfolio Page description text ...'; //для хранения мета-данных(описание) для страницы
        $this->_title= 'PORTFOLIO'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @param bool/string $alias - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function index( $alias=FALSE  ) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        $configPortfolioPagination = Config::get('settings.portfolios_pagination'); //пагинация для Blog(Articles) на стр.`../articles` //settings - означает,что в файле `settings.php`
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
        if( !$alias ) {  //Если нет входящего парам.`$alias`, то формируем контент страницы где все записи(portfolios) и,значит у нас страница `/portfolios` и будет отрабатывать Route `articles`
            //Data of Portfolio:
            $get_portfolio = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objPortfolio,false, $configPortfolioPagination,  array('PortfolioFilters'), array()
            ); //for Portfolio list with Pagination
        }
        else {  //Если есть входящий парам.`$alias`, то формируем контент такой страницы с учетом этого параметра,отображая записи(portfolios) только определен.категории и,значит,у нас страница `/portfolios/cat/$alias` и будет отрабатывать Route `portfolios_cat`
            $get_portfolio = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objPortfolio,false, $configPortfolioPagination, array('PortfolioFilters'), array('portfolio_filter_alias', '=', $alias)
            ); //for Portfolio belonging to a particular (specific) filter(category)
        }

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/frontendsite/pink/index.blade.php` - "content" для "PORTFOLIO" page
        $content_page = view('frontendsite.'.env('THEME').'.include._portfolio')
            ->with( 'list_portfolio', $get_portfolio ); //Данные для Portfolio (with pagination)

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    }  //__/public function index()


    /** Display the specified resource.
     * @param string $alias - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function show( $alias ) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
        $get_single_portfolio = SiteMainController::get_entries_with_settings(
            SiteMainController::$_objPortfolio,false,false, array('PortfolioFilters'), array('alias','=',$alias)
        );

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING динамическую секцию шаблона `resources/views/frontendsite/pink/index.blade.php` - "content" для "Single" page of article
        $content_page = view('frontendsite.'.env('THEME').'.include._single_portfolio')
            ->with( 'single_portfolio', $get_single_portfolio ); //Данные для single article (without pagination)

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function show()



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

}  //__/PortfolioResourceController
