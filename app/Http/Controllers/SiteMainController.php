<?php
namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Menu;
use App\Slider;
use App\Portfolio;
use App\PortfolioFilter;
use App\Article;
use App\Comment;

class SiteMainController extends Controller //Главный(родит.Контроллер) для фронтенд-части сайта
{
    protected static $_objMenu; //для хранения Объекта Класса Menu (репозитория Menu)- хранения логики при работе с Menu (пунктами Меню)
    protected static $_objPortfolio; //для хранения Объекта Класса Portfolio (репозитория Portfolio)- хранения логики при работе с Portfolio
    protected static $_objPortfolioFilter;
    protected static $_objSlider; //для хранения Объекта Класса Slider (репозитория Slider)- хранения логики при работе с Slider
    protected static $_objArticle; //для хранения Объекта Класса Article (репозитория Article)- хранения логики при работе с Article
    protected static $_objComment; //для хранения Объекта Класса Comment (репозитория Comment)- хранения логики при работе с Comment

    protected $_template_view_name; //имя шаблона (View) для конкретной страницы. Запросы будут обрабатывать дочерние Контроллеры
    public $show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View

    protected $_vars_for_template_view = array(); //массив с переменными,кот.будут передаваться в шаблон(View)
    protected $_bar_for_template_view = FALSE; //переменная-флаг,для обозначения есть ли у шаблона(View) сайт-бар и какой или его нет вообще. По-умолч. FALSE - сайт-бара нет
    protected $_rightbar_for_template_view = FALSE; //данные для правого сайт-бара,если он есть у шаблона(View). По-умолч. FALSE - данных для Правого сайт-бара нет
    protected $_leftbar_for_template_view = FALSE; //данные для левого сайт-бара,если он есть у шаблона(View). По-умолч. FALSE - данных для Левого сайт-бара нет

    protected $_keywords; //для хранения ключевых слов для мета-тегов страницы
    protected $_meta_description; //для хранения мета-данных(описание) для страницы
    protected $_title; //для хранения title для вкладки странницы (отображение названия страницы на вкладке браузера)

    //protected $request; //для Объекта Класса `Request` с которым мы будем в данном Контроллере работать.
    //_______________________________________________________________________________________________________________________________________________________________________

    /* Определяем зн-е некоторых общих свойств для остальных-дочерн.Контроллеров для фронт.-части сайта */
    public function __construct(){ //Request $request. Request $request - Объект Класса `Request`
        self::$_objMenu = new Menu();
        self::$_objSlider = new Slider();
        self::$_objPortfolio = new Portfolio();
        self::$_objPortfolioFilter = new PortfolioFilter();
        self::$_objArticle = new Article();
        self::$_objComment = new Comment();
    }
    //_______________________________________________________________________________________________________________________________________________________________________

    /** Return View with data
     *  @return
    */
    protected function renderOutput() {
        if( view()->exists( $this->_template_view_name ) ) { //проверяем, есть ли такая View по такому пути, если да, то тогда ее будем рендерить в метод view()
            return view( $this->_template_view_name, [
                'vars_for_template_view' => $this->_vars_for_template_view, //массив - наш контейнер для данных кот.мы будем передавать во View
                'nav_menu' => $this->forming_nav_menu(), //Меню(из БД таб.`menus`) уже сформированное для вывода(родительские пункты и подпункты)
                'keywords' => $this->_keywords,  //ключевые слова для мета-тегов страницы
                'meta_description' => $this->_meta_description,  //мета-данные(описание) для страницы
                'title' => $this->_title,  //title для вкладки странницы (отображение названия страницы на вкладке браузера)
            ] )->render(); //->render() - можно не писать;
        }
        else { abort(404); }
    }


    /** Forming Nav-Menu(parent Item Menu with sub-Item menu if it exists) for frontend-part
     *  @return  array
    */
    protected static function forming_nav_menu() {
        $result_menu = Menu::get_all_menu();
        $parent_menu_items = array();
        $child_menu_items = array();

        for( $i=0, $cnt=count($result_menu)  ; $i < $cnt; ++$i ) {
            if( $result_menu[$i]['parent_menu_id'] == 0 ) {  //если это родительский пункт Меню. У такового ['parent_menu_id'] == 0
                $parent_menu_items[] = $result_menu[$i];
            }
            else { //если дочерний пункт меню. У такового ['parent_menu_id'] !== 0
                $child_menu_items[] = $result_menu[$i];
            }
        } //_endfor

        //$result_menu = array();
        //$result_menu['parent'] = $parent_menu_items;
        //$result_menu['child'] = $child_menu_items;

        for( $k=0,$cnt=count($parent_menu_items); $k<$cnt; ++$k ){ //level#1
            for( $k2=0,$cnt2=count($child_menu_items); $k2<$cnt2; ++$k2 ){ //level#2
                if( in_array( ($parent_menu_items[$k]['id']), $child_menu_items[$k2]) ) {
                    $parent_menu_items[$k]['submenu'][] = ($child_menu_items[$k2]);
                }//end level#2
            }//end level#1
        }
        $result_menu = array(); //очищаем массив для нового содержимого

        return $result_menu = $parent_menu_items;
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
    }


    /** Get entries with limit
     * @param $entries - entries
     * @param int $take - number of entries you need to take
     * @param bool/int $reverse - take entries from the beginning or the end. If TRUE - take from end
     * @return array/object(collection Models)
    */
    public static function get_entries_limit( $entries, $take, $reverse=FALSE ) {
        if( is_array($entries) ) {  //if input Array
            if( !$reverse ) { $result_entries = array_slice($entries, 0, $take); }
            else { $result_entries = array_slice( array_reverse( $entries, false ), 0, $take ); }
        }
        else { //if input Object(collection Models)
            if( !$reverse ) {
                $obj_x_length = count($entries);
                $marker_end = $take;
                $result_entries_x = new Collection();

                for( $i=0; $i < $obj_x_length; $i++ ) {
                    if( $i < $marker_end ) {
                        $result_entries_x[] = (object)$entries[$i];
                    }
                }
               $result_entries = $result_entries_x;
            }
            else {  //if input Object(collection Models)
                $obj_x_length = count($entries);
                $marker_end = ( $obj_x_length - $take );
                $result_entries_x = new Collection();

                for( $i=0; $i < $obj_x_length; $i++ ) {
                    if( $i > ($marker_end - 1) ) {
                        $result_entries_x[] = (object)$entries[$i];
                    }
                }
                $result_entries = $result_entries_x->reverse();
            }
        }
        return $result_entries;
    }

}  //__/class SiteMainController