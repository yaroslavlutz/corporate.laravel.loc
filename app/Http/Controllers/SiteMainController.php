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

class SiteMainController extends Controller
{
    protected static $_objMenu; 
    protected static $_objPortfolio;
    protected static $_objPortfolioFilter;
    protected static $_objSlider; 
    protected static $_objArticle;
    protected static $_objComment;

    protected $_template_view_name;
    public $show_controller_info = __METHOD__;

    protected $_vars_for_template_view = array();
    protected $_bar_for_template_view = FALSE;
    protected $_rightbar_for_template_view = FALSE;
    protected $_leftbar_for_template_view = FALSE;

    protected $_keywords;
    protected $_meta_description;
    protected $_title; 

    public function __construct(){
        self::$_objMenu = new Menu();
        self::$_objSlider = new Slider();
        self::$_objPortfolio = new Portfolio();
        self::$_objPortfolioFilter = new PortfolioFilter();
        self::$_objArticle = new Article();
        self::$_objComment = new Comment();
    }

    /** Return View with data
     *  @return
    */
    protected function renderOutput() {
        if( view()->exists( $this->_template_view_name ) ) {
            return view( $this->_template_view_name, [
                'vars_for_template_view' => $this->_vars_for_template_view,
                'nav_menu' => $this->forming_nav_menu(),
                'keywords' => $this->_keywords,
                'meta_description' => $this->_meta_description,
                'title' => $this->_title,
            ] )->render();
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
            if( $result_menu[$i]['parent_menu_id'] == 0 ) {
                $parent_menu_items[] = $result_menu[$i];
            }
            else {
                $child_menu_items[] = $result_menu[$i];
            }
        }

        for( $k=0,$cnt=count($parent_menu_items); $k<$cnt; ++$k ){ //level#1
            for( $k2=0,$cnt2=count($child_menu_items); $k2<$cnt2; ++$k2 ){ //level#2
                if( in_array( ($parent_menu_items[$k]['id']), $child_menu_items[$k2]) ) {
                    $parent_menu_items[$k]['submenu'][] = ($child_menu_items[$k2]);
                }//end level#2
            }//end level#1
        }
        $result_menu = array();

        return $result_menu = $parent_menu_items;
    } 


    /** Get entries with settings
     * @param object $objModel - object of current and needs Model
     * @param bool/array $select - array with the listed fields that you need to take
     * @param bool/str $pagination - Pagination(how many entries to display on one page)
     * @param bool $relationload - Load into the data sample the data of the relationship Models or not. If FALSE - not
     * @return object (collection Models)
    */
    public static function get_entries_with_settings( $objModel, $select=FALSE, $pagination=FALSE, $relationload=FALSE, $where=array() ) {
        if( !$pagination ) {
            if( !$select ) {
                $result_entries = $objModel::get_entries( false,false,false,$where );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( false, false, $relationload, $where ); }
            }
            else {
                $result_entries = $objModel::get_entries( $select,false,false,$where );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( $select, false, $relationload, $where ); }
            }
        }
        else {
            if( !$select ) { 
                $result_entries = $objModel::get_entries( false,$pagination,false );
                if( $result_entries && $relationload ) { $result_entries = $objModel::get_entries( false, $pagination, $relationload, $where ); }
            }
            else { 
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
        if( is_array($entries) ) {
            if( !$reverse ) { $result_entries = array_slice($entries, 0, $take); }
            else { $result_entries = array_slice( array_reverse( $entries, false ), 0, $take ); }
        }
        else {
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
            else {
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
}
