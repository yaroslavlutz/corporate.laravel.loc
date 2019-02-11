<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\PortfolioFilter;

class PortfolioResourceController extends SiteMainController
{
    public function __construct() {
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index';
        $this->_bar_for_template_view = FALSE;)
        $this->_keywords = 'Portfolio Page, Corporate site, LITTUS';
        $this->_meta_description = 'Portfolio Page description text ...';
        $this->_title= 'PORTFOLIO';
    }

    /** Display a listing of the resource.
     * @param bool/string $alias - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function index( $alias=FALSE  ) {
        $this->show_controller_info = __METHOD__;
        $configPortfolioPagination = Config::get('settings.portfolios_pagination'); 

        if( !$alias ) {  
            //Data of Portfolio:
            $get_portfolio = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objPortfolio,false, $configPortfolioPagination,  array('PortfolioFilters'), array()
            ); 
        }
        else { 
            $get_portfolio = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objPortfolio,false, $configPortfolioPagination, array('PortfolioFilters'), array('portfolio_filter_alias', '=', $alias)
            ); 
        }

        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info;
        $content_page = view('frontendsite.'.env('THEME').'.include._portfolio')
            ->with( 'list_portfolio', $get_portfolio );

        $this->_vars_for_template_view['page_content'] = $content_page;
        return $this->renderOutput();

    }


    /** Display the specified resource.
     * @param string $alias - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function show( $alias ) {
        $this->show_controller_info = __METHOD__;
        $get_single_portfolio = SiteMainController::get_entries_with_settings(
            SiteMainController::$_objPortfolio,false,false, array('PortfolioFilters'), array('alias','=',$alias)
        );

        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info;
        $content_page = view('frontendsite.'.env('THEME').'.include._single_portfolio')
            ->with( 'single_portfolio', $get_single_portfolio );
        $this->_vars_for_template_view['page_content'] = $content_page;
        return $this->renderOutput();

    } 

}
