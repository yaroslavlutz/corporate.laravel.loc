<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

use App\Menu;
use App\Slider;
use App\Portfolio;
use App\PortfolioFilter;
use App\Article;
use App\ArticleCategory;
use App\Comment;
use App\User;
use App\Permission;
use App\Role;

class AdminMainController extends Controller  //Главный(родит.Контроллер) для backend-части сайта
{
    protected static $_objMenu; //для хранения Объекта Класса Menu (репозитория Menu)- хранения логики при работе с Menu (пунктами Меню)
    protected static $_objPortfolio; //для хранения Объекта Класса Portfolio (репозитория Portfolio)- хранения логики при работе с Portfolio
    protected static $_objPortfolioFilter;
    protected static $_objSlider; //для хранения Объекта Класса Slider (репозитория Slider)- хранения логики при работе с Slider
    protected static $_objArticle; //для хранения Объекта Класса Article (репозитория Article)- хранения логики при работе с Article
    protected static $_objArticleCategory; //для хранения Объекта Класса ArticleCategory (репозитория ArticleCategory)- хранения логики при работе с ArticleCategory
    protected static $_objComment; //для хранения Объекта Класса Comment (репозитория Comment)- хранения логики при работе с Comment
    protected static $_objUser; //для хранения Объекта Класса User (репозитория User)- хранения логики при работе с User
    protected static $_objPermission; //для хранения Объекта Класса Permission (репозитория Permission)- хранения логики при работе с Permission
    protected static $_objRole; //для хранения Объекта Класса Role (репозитория Role)- хранения логики при работе с Role

    protected $_template_view_name; //имя шаблона (View) для конкретной страницы. Запросы будут обрабатывать дочерние Контроллеры
    public $show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
    protected $_vars_for_template_view = array(); //массив с переменными,кот.будут передаваться в шаблон(View)
    protected $_title; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)

    protected $_currentUser = NULL;
    //protected $request; //для Объекта Класса `Request` с которым мы будем в данном Контроллере работать.
    //_______________________________________________________________________________________________________________________________________________________________________

    /* Определяем зн-е некоторых общих свойств для остальных-дочерн.Контроллеров для фронт.-части сайта */
    public function __construct(){ //Request $request. Request $request - Объект Класса `Request`
        self::$_objMenu = new Menu();
        self::$_objSlider = new Slider();
        self::$_objPortfolio = new Portfolio();
        self::$_objPortfolioFilter = new PortfolioFilter();
        self::$_objArticle = new Article();
        self::$_objArticleCategory = new ArticleCategory();
        self::$_objComment = new Comment();
        self::$_objUser = new User();
        self::$_objPermission = new Permission;
        self::$_objRole = new Role;

        //$this->_currentUser = Auth::user(); //попадает идентифицированный(залогиненный) Юзер
       // if( !$this->_currentUser ) { abort(403); }  //Если текущий Юзер не залогинен,то ему в раздел "Admin" нет доступа (хотя это можно и не писать,-сам роут находится в группе 'middleware'=>['auth'])
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Return View with data
     *  @return
    */
    protected function renderOutput() {
        if( view()->exists( $this->_template_view_name ) ) { //проверяем, есть ли такая View по такому пути, если да, то тогда ее будем рендерить в метод view()
            return view( $this->_template_view_name, [
                'vars_for_template_view' => $this->_vars_for_template_view, //массив - наш контейнер для данных кот.мы будем передавать во View
                'nav_menu' => $this->forming_nav_menu(), //Меню для Админки с нужными разделами для редактированию
                'title' => $this->_title,  //title для вкладки странницы (отображение названия страницы на вкладке браузера)
            ] )->render(); //->render() - можно не писать;
        }
        else { abort(404); }
    }

    /** Forming Nav-Menu for frontend-part
     *  @return  array
    */
    protected static function forming_nav_menu() {
        $result_menu = array();
        $result_menu['menus'] = array('title'=>'Menus', 'alias'=>'menus');
        $result_menu['articles'] = array('title'=>'Articles', 'alias'=>'articles');
        $result_menu['articles_categories'] = array('title'=>'Articles Categories', 'alias'=>'articles_categories');
        $result_menu['portfolios'] = array('title'=>'Portfolios', 'alias'=>'portfolios');
        $result_menu['portfolio_filters'] = array('title'=>'Portfolio Filters', 'alias'=>'portfolio_filters');
        $result_menu['sliders'] = array('title'=>'Sliders', 'alias'=>'sliders');
        $result_menu['users'] = array('title'=>'Users', 'alias'=>'users');
        $result_menu['permissions'] = array('title'=>'Permissions', 'alias'=>'permissions');
        return $result_menu;
    }  //__/protected function forming_nav_menu()


    /** Get entries with settings
     * @param object $objModel - object of current and needs Model
     * @param bool/array $select - array with the listed fields that you need to take
     * @param bool/str $pagination - Pagination(how many entries to display on one page)
     * @param bool $relationload - Load into the data sample the data of the relationship Models or not. If FALSE - not
     * @return object (collection Models)
    */
    public static function get_entries_with_settings( $objModel, $select=FALSE, $pagination=FALSE, $relationload=FALSE, $where=array() ) {
        //Если пагинация не нужна
        if( !$pagination ) {
            if( !$select ) { //Если не передаем свой массив полей для выборки данных
                $result_entries = $objModel::get_entries( false,false,false,$where );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( false, false, $relationload, $where ); }
            }
            else { //Если передаем свой массив полей для выборки данных
                $result_entries = $objModel::get_entries( $select,false,false,$where );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( $select, false, $relationload, $where ); }
            }
        }
        //Если пагинация нужна
        else {
            if( !$select ) { //Если не передаем свой массив полей для выборки данных
                $result_entries = $objModel::get_entries( false,$pagination,false );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( false, $pagination, $relationload, $where ); }
            }
            else { //Если передаем свой массив полей для выборки данных
                $result_entries = $objModel::get_entries( $select,$pagination,false  );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( $select, $pagination, $relationload, $where ); }
            }
        }
        return $result_entries;
    } //__/protected function get_entries_with_settings()


    /** Делает транслитерацию строки,например есть заголовок(title) Статьи на русском или английском и для автоматического получения его alias`a применяем транслитерацию,- получае alias такого заголовка
     * @param string $string - string from which you need to make a string with transliteration
     * @param bool $space_replace_dash - dash or underline should be used to replace spaces. If TRUE - use '-'
     * @return string
    */
    public function transliterate( $string, $space_replace_dash=TRUE ) {
        if( $space_replace_dash ){ $replace = '-'; } else { $replace = '_'; } //если $space_replace_dash == TRUE,то используем в качестве замены для пробелов,символ тире '-'. Иначе используем '_'
        $str = mb_strtolower($string, 'UTF-8');
        $leter_array = array(
            'a'=>'а','b'=>'б','v'=>'в','g'=>'г,ґ','d'=>'д','e'=>'е,є,э','jo'=>'ё','zh'=>'ж','z'=>'з','i'=>'и,і','ji'=>'ї','j'=>'й','k'=>'к','l'=>'л','m'=>'м','n'=>'н','o'=>'о','p'=>'п','r'=>'р','s'=>'с','t'=>'т','u'=>'у','f'=>'ф','kh'=>'х','ts'=>'ц','ch'=>'ч','sh'=>'ш','shch'=>'щ',''=>'ъ','y'=>'ы',''=>'ь','yu'=>'ю','ya'=>'я'
        );

        foreach( $leter_array as $leter => $kyril ) {
            $kyril = explode( ',', $kyril ); //там где комбинации из 2-х и более символов для киррилицы ('е,є,э' или 'г,ґ'),разбиваем на отдельные ячейки массива
            $str = str_replace( $kyril, $leter, $str );
        }
        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', $replace, $str); //Заменять пробелы в словах строчными символами и тире(или нижн.подчерк.,- в зависимости от передаваемого парам. $space_replace_dash)
        $str = trim( $str,'-'); //обзезаем,если получился автоматически последний символ '-'
        $str = trim( $str,'_'); //обзезаем,если получился автоматически последний символ '_'
        return $str;

    } //__/public function transliterate()


}  //__/class AdminMainController
