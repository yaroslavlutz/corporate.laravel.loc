<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; //or: use Config;

use App\ArticleCategory;

class ArticleResourceController extends SiteMainController
{
    /* Положенно перегружаем тут родит.Контроллер и переопределяем некоторые его св-ва для данного Контроллера,которые нам нужны только в этом Контроллере */
    public function __construct() { //Request $request. Request $request - Объект Класса `Request`
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index'; //переопределяем(конкретизируем) шаблон,который должен и будет рендерить этот Контроллер - `frontendsite.pink.index`
        $this->_bar_for_template_view = TRUE; //переопределяем св-во и это значит,что на View,котрое мы будем этим Контроллером рендерить есть сайт-бар

        $this->_keywords = 'Blog Page, Corporate site, LITTUS'; //для хранения ключевых слов для мета-тегов страницы
        $this->_meta_description = 'Blog Page description text ...'; //для хранения мета-данных(описание) для страницы
        $this->_title= 'BLOG'; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Display a listing of the resource.
     * @param bool/string $cat - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function index( $cat=FALSE ) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        $configLimitPortfoliosShowSideBar = Config::get('settings.limit_portfolios_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configLimitArticlesShowSideBar = Config::get('settings.limit_articles_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configLimitCommentsShowSideBar = Config::get('settings.limit_comments_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configArticlesPagination = Config::get('settings.articles_pagination'); //пагинация для Blog(Articles) на стр.`../articles` //settings - означает,что в файле `settings.php`
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
            //Data of Portfolio:
        $get_portfolio_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Portfolio list in side-bar
            //Data of Articles:
        $get_articles_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objArticle, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Articles list in side-bar
        if( !$cat ) {  //Если нет входящего парам.`$cat`, то формируем контент страницы где все записи(articles) и,значит у нас страница `/articles` и будет отрабатывать Route `articles`
            $get_articles_blog = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objArticle,false, $configArticlesPagination, array('users','articlesCategories', 'comments'), array()
            ); //for Articles of Blog with Pagination
        }
        else {  //Если есть входящий парам.`$cat`, то формируем контент такой страницы с учетом этого параметра,отображая записи(articles) только определен.категории и,значит,у нас страница `/articles/cat/$cat` и будет отрабатывать Route `articles_cat`
            $idArticleCategory = ArticleCategory::get_cat_id($cat)->toArray()[0]['id'];
            $get_articles_blog = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objArticle,false, $configArticlesPagination, array('users','articlesCategories', 'comments'), array('articles_category_id', '=', $idArticleCategory)
            ); //for Articles of Blog belonging to a particular (specific) category
        }

            //Data of Comments:
        $get_comments_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objComment, false,false, array('users','articles'), array() )->toArray(); //for Comment list in side-bar


        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING Right Side-bar шаблона `resources/views/frontendsite/pink/index.blade.php`
        if( $this->_bar_for_template_view ) {  //если это св-во родит.Контроллера переопределено как TRUE, значит что хотим использовать и формировать Side-bar
            $this->_rightbar_for_template_view = view('frontendsite.'.env('THEME').'.include._right_side_bar')
                ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio_side_bar, $configLimitPortfoliosShowSideBar,true ) ) //Данные для Portfolios для Side-bar
                ->with( 'articles', SiteMainController::get_entries_limit( $get_articles_side_bar, $configLimitArticlesShowSideBar,true ) ) //Данные для Articles для Side-bar
                ->with( 'comments', SiteMainController::get_entries_limit( $get_comments_side_bar, $configLimitCommentsShowSideBar,true ) ); //Данные для Comments для Side-bar
        }

        //=> FORMING динамическую секцию шаблона `resources/views/frontendsite/pink/index.blade.php` - "content" для "BLOG" page
        $content_page = view('frontendsite.'.env('THEME').'.include._blog')
                        ->with( 'right_sidebar_content', $this->_rightbar_for_template_view ) //Отрендеринная View с правым сайт-баром и данными для него
                        ->with( 'blog_articles', $get_articles_blog ); //Данные для Articles (with pagination)

        //=> RENDER View and DATA for View
        $this->_vars_for_template_view['page_content'] = $content_page; //передаем в наш основной(Главн.) массив с переменными отрендеринную View с нужными данными
        return $this->renderOutput();
    } //__/public function index()


    /** Display the specified resource.
     * @param string $alias - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function show( $alias ) {
        $this->show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        $configLimitPortfoliosShowSideBar = Config::get('settings.limit_portfolios_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configLimitArticlesShowSideBar = Config::get('settings.limit_articles_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        $configLimitCommentsShowSideBar = Config::get('settings.limit_comments_show_side_bar'); //параметр настройки из `config/settings.php` //settings - означает,что в файле `settings.php`
        //______________________________________________________________________________________________________________________________________________________

        //=> GET DATA(from DB) THROUGH the MODEL:
            //Data of Portfolio:
        $get_portfolio_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Portfolio list in side-bar
            //Data of Articles:
        $get_articles_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objArticle, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Articles list in side-bar
        $get_single_article = SiteMainController::get_entries_with_settings(
            SiteMainController::$_objArticle,false,false, array('users','articlesCategories','comments'), array('alias','=',$alias)
        );
            //Data of Comments:
        $get_comments_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objComment, false,false, array('users','articles'), array() )->toArray(); //for Comment list in side-bar

        //=> FORMING THE MAIN ARRAY with DATA FOR THE TEMPLATE:
        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; //информационно - метод и Контроллер,отображающие View

        //=> FORMING Right Side-bar шаблона `resources/views/frontendsite/pink/index.blade.php`
        if( $this->_bar_for_template_view ) {  //если это св-во родит.Контроллера переопределено как TRUE, значит что хотим использовать и формировать Side-bar
            $this->_rightbar_for_template_view = view('frontendsite.'.env('THEME').'.include._right_side_bar')
                ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio_side_bar, $configLimitPortfoliosShowSideBar,true ) ) //Данные для Portfolios для Side-bar
                ->with( 'articles', SiteMainController::get_entries_limit( $get_articles_side_bar, $configLimitArticlesShowSideBar,true ) ) //Данные для Articles для Side-bar
                ->with( 'comments', SiteMainController::get_entries_limit( $get_comments_side_bar, $configLimitCommentsShowSideBar,true ) ); //Данные для Comments для Side-bar
        }

        //=> FORMING динамическую секцию шаблона `resources/views/frontendsite/pink/index.blade.php` - "content" для "Single" page of article
        $content_page = view('frontendsite.'.env('THEME').'.include._single_article')
            ->with( 'right_sidebar_content', $this->_rightbar_for_template_view ) //Отрендеринная View с правым сайт-баром и данными для него
            ->with( 'single_article', $get_single_article ); //Данные для single article (without pagination)

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

} //__/class ArticleResourceController
