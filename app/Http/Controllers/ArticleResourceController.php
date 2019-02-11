<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\ArticleCategory;

class ArticleResourceController extends SiteMainController
{
    public function __construct() {
        parent::__construct();
        $this->_template_view_name = 'frontendsite.'.env('THEME').'.index';
        $this->_bar_for_template_view = TRUE; 

        $this->_keywords = 'Blog Page, Corporate site, LITTUS'; 
        $this->_meta_description = 'Blog Page description text ...'; 
        $this->_title= 'BLOG'; 
    }

    /** Display a listing of the resource.
     * @param bool/string $cat - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function index( $cat=FALSE ) {
        $this->show_controller_info = __METHOD__; 
        $configLimitPortfoliosShowSideBar = Config::get('settings.limit_portfolios_show_side_bar');
        $configLimitArticlesShowSideBar = Config::get('settings.limit_articles_show_side_bar'); 
        $configLimitCommentsShowSideBar = Config::get('settings.limit_comments_show_side_bar'); 
        $configArticlesPagination = Config::get('settings.articles_pagination'); 
            //Data of Portfolio:
        $get_portfolio_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Portfolio list in side-bar
            //Data of Articles:
        $get_articles_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objArticle, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Articles list in side-bar
        if( !$cat ) { 
            $get_articles_blog = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objArticle,false, $configArticlesPagination, array('users','articlesCategories', 'comments'), array()
            );
        }
        else { 
            $idArticleCategory = ArticleCategory::get_cat_id($cat)->toArray()[0]['id'];
            $get_articles_blog = SiteMainController::get_entries_with_settings(
                SiteMainController::$_objArticle,false, $configArticlesPagination, array('users','articlesCategories', 'comments'), array('articles_category_id', '=', $idArticleCategory)
            ); 
        }

            //Data of Comments:
        $get_comments_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objComment, false,false, array('users','articles'), array() )->toArray(); //for Comment list in side-bar

        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; 
        if( $this->_bar_for_template_view ) { 
            $this->_rightbar_for_template_view = view('frontendsite.'.env('THEME').'.include._right_side_bar')
                ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio_side_bar, $configLimitPortfoliosShowSideBar,true ) ) 
                ->with( 'articles', SiteMainController::get_entries_limit( $get_articles_side_bar, $configLimitArticlesShowSideBar,true ) )
                ->with( 'comments', SiteMainController::get_entries_limit( $get_comments_side_bar, $configLimitCommentsShowSideBar,true ) );
        }
        $content_page = view('frontendsite.'.env('THEME').'.include._blog')
                        ->with( 'right_sidebar_content', $this->_rightbar_for_template_view ) 
                        ->with( 'blog_articles', $get_articles_blog );
        $this->_vars_for_template_view['page_content'] = $content_page; 
        return $this->renderOutput();
    } 


    /** Display the specified resource.
     * @param string $alias - parameter for URL
     * @return \Illuminate\Http\Response
    */
    public function show( $alias ) {
        $this->show_controller_info = __METHOD__; 
        $configLimitPortfoliosShowSideBar = Config::get('settings.limit_portfolios_show_side_bar'); 
        $configLimitArticlesShowSideBar = Config::get('settings.limit_articles_show_side_bar');
        $configLimitCommentsShowSideBar = Config::get('settings.limit_comments_show_side_bar');
            //Data of Portfolio:
        $get_portfolio_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objPortfolio, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Portfolio list in side-bar
            //Data of Articles:
        $get_articles_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objArticle, array('id','alias','title','created_at'),false,false, array() )->toArray(); //for Articles list in side-bar
        $get_single_article = SiteMainController::get_entries_with_settings(
            SiteMainController::$_objArticle,false,false, array('users','articlesCategories','comments'), array('alias','=',$alias)
        );
            //Data of Comments:
        $get_comments_side_bar = SiteMainController::get_entries_with_settings( SiteMainController::$_objComment, false,false, array('users','articles'), array() )->toArray(); //for Comment list in side-bar

        $this->_vars_for_template_view['show_controller_info'] = $this->show_controller_info; 

        if( $this->_bar_for_template_view ) { 
            $this->_rightbar_for_template_view = view('frontendsite.'.env('THEME').'.include._right_side_bar')
                ->with( 'portfolios', SiteMainController::get_entries_limit( $get_portfolio_side_bar, $configLimitPortfoliosShowSideBar,true ) ) 
                ->with( 'articles', SiteMainController::get_entries_limit( $get_articles_side_bar, $configLimitArticlesShowSideBar,true ) )
                ->with( 'comments', SiteMainController::get_entries_limit( $get_comments_side_bar, $configLimitCommentsShowSideBar,true ) ); 
        }

        $content_page = view('frontendsite.'.env('THEME').'.include._single_article')
            ->with( 'right_sidebar_content', $this->_rightbar_for_template_view ) 
            ->with( 'single_article', $get_single_article ); 

        $this->_vars_for_template_view['page_content'] = $content_page; 
        return $this->renderOutput();

    }

} 
