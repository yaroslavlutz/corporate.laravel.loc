<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; //or: use Config;

class IndexResourceController extends SiteMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.pink.index`
        $this->_bar_for_template_view = TRUE; //переопределяем св-во и это значит,что на View,котрое мы будем этим Контроллером рендерить есть сайт-бар

        $this->_keywords = 'Home Page, Corporate site, LITTUS'; //для хранения ключевых слов для мета-тегов страницы
        $this->_meta_description = 'Home Page description text ...'; //для хранения мета-данных(описание) для страницы
        $this->_title= 'HOME'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        $configCountPortfoliosHomeShow = Config::get('settings.count_portfolios_home_show'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configLimitPortfoliosShowSideBar = Config::get('settings.limit_portfolios_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configLimitArticlesShowSideBar = Config::get('settings.limit_articles_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
            //Data of Slider:
        $get_slider = SiteMainController::get_entries_with_settings( SiteMainController::$_objSlider,false,false,false, array() )->toArray(); //for Slider (in Slider section on Home)
            //Data of Portfolio:
        $get_portfolio = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, false,false,false, array() )->toArray(); //for Portfolio Section
        $get_portfolio_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Portfolio list in side-bar
            //Data of Portfolio filters
        $get_portfolio_filters = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolioFilter, false,false,false, array() )->toArray(); //for Portfolio Section
            //Data of Articles
        $get_articles_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objArticle, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Articles list in side-bar


        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View
        $this->_vars_for_template_view['slides'] = $get_slider; //Данные для Slider`a


        //=> FORMING Right Side-bar шаблона `resources/views/frontendsite/pink/index.blade.php`
        if( $this->_bar_for_template_view ) {  //если это св-во родит.Контроллера переопределено как TRUE, значит что хотим использовать и формировать Side-bar
            $this->_rightbar_for_template_view = view('frontendsite.'.env('THEME').'.include._right_side_bar')
                ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio_side_bar, $configLimitPortfoliosShowSideBar,true) ) //Данные для Portfolios для Side-bar
                ->with( 'articles', SiteMainController::get_entries_limit( $get_articles_side_bar, $configLimitArticlesShowSideBar,true ) ); //Данные для Articles для Side-bar
        }

        //=> FORMING динамическую секцию шаблона `resources/views/frontendsite/pink/index.blade.php` - "content" для "HOME" page
        $content_page = view('frontendsite.'.env('THEME').'.include._home')
                        ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio, $configCountPortfoliosHomeShow, false ) ) //Данные для Portfolios
                        ->with( 'portfolio_filters', $get_portfolio_filters ) //Данные для Portfolio filters
                        ->with( 'right_sidebar_content', $this->_rightbar_for_template_view ); //Отрендеринная View  с правым сайт-баром и данными для него

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();

    } //__/public function index()


    /** Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
    */ public function create() {}

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

} //__/class IndexResourceController
