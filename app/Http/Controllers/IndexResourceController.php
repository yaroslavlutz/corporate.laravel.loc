<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class IndexResourceController extends SiteMainController
{
    public function __construct() { 
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index';
        $this->_bar_for_template_view = TRUE;

        $this->_keywords = 'Home Page, Corporate site, LITTUS';
        $this->_meta_description = 'Home Page description text ...';
        $this->_title= 'HOME';
    }

    /** Display a listing of the resource.
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $this->show_controller_info = __METHOD__;
        $configCountPortfoliosHomeShow = Config::get('settings.count_portfolios_home_show');
        $configLimitPortfoliosShowSideBar = Config::get('settings.limit_portfolios_show_side_bar');
        $configLimitArticlesShowSideBar = Config::get('settings.limit_articles_show_side_bar');
            //Data of Slider:
        $get_slider = SiteMainController::get_entries_with_settings( SiteMainController::$_objSlider,false,false,false, array() )->toArray(); //for Slider (in Slider section on Home)
            //Data of Portfolio:
        $get_portfolio = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, false,false,false, array() )->toArray(); //for Portfolio Section
        $get_portfolio_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, array('id','alias','title','created_at'),false,false, array() )->toArray(); 
         
        $get_portfolio_filters = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolioFilter, false,false,false, array() )->toArray(); //for Portfolio Section
            //Data of Articles
        $get_articles_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objArticle, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Articles list in side-bar

        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info;
        $this->_vars_for_template_view['slides'] = $get_slider; 

        if( $this->_bar_for_template_view ) {
            $this->_rightbar_for_template_view = view('frontendsite.'.env('THEME').'.include._right_side_bar')
                ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio_side_bar, $configLimitPortfoliosShowSideBar,true) ) 
                ->with( 'articles', SiteMainController::get_entries_limit( $get_articles_side_bar, $configLimitArticlesShowSideBar,true ) ); 
        }

          $content_page = view('frontendsite.'.env('THEME').'.include._home')
                        ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio, $configCountPortfoliosHomeShow, false ) )
                        ->with( 'portfolio_filters', $get_portfolio_filters ) 
                        ->with( 'right_sidebar_content', $this->_rightbar_for_template_view );

        $this->_vars_for_template_view['page_content'] = $content_page;
        return $this->renderOutput();

    }

}
