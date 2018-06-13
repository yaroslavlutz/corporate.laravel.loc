<?php
//dump($portfolios);
//dump($portfolio_filters);
//dump($right_sidebar_content);
//dump($blog_articles);

/*Делаем динамическими классы Bootstrap, в зависимости от того передается сюда в макет Side-bar или нет. Если сайт бар определен,то колонки смежной с Side-bar`ом секции будут `9` иначе будут на всю ширину- `12` */
( $right_sidebar_content ) ? $class_num = 9 : $class_num = 12;
?>

<!-- BlogList Section -->
<div id="bloglist_anchor_section" class="bloglist-section" style="margin-top:145px;">
    <div class="container-fluid">
        <h1 class="wow slideInLeft" data-wow-duration="2.5s" data-wow-delay="0.3s" data-wow-offset="120">
            <a href="" style="text-transform:uppercase; color:gray; text-decoration:none;"> <?=( App::getLocale() == 'en' ) ? 'Blog list' : trans('custom_ru.blog_list');?>: </a>
        </h1>
        <p class="wow slideInLeft" data-wow-duration="3.5s" data-wow-delay="0.5s" data-wow-offset="120" style="font-size:15px;">
            <?=( App::getLocale() == 'en' ) ? 'Articles of Blog' : trans('custom_ru.all_articles_blog');?>:
        </p>

        <!--BlogList-->
        <div class="col-lg-<?=$class_num;?> col-md-<?=$class_num;?> text-center">
            <?php if( isset($blog_articles) && is_object($blog_articles) && count($blog_articles) ): ?>
            <ul id="ul_blog_list" class="ul-blog-list">

                <?php foreach( $blog_articles as $blog_article ): ?>
                <li id="li_blog_list_id_<?=$blog_article->id;?>" class="li-blog-list"
                            data-alias="<?=$blog_article->alias;?>"
                            data-articlescat="<?=$blog_article->articles_category_id;?>"
                            data-userid="<?=$blog_article->user_id;?>">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 article-desc">
                            <a href="{{ route('articles.show', ['alias' => $blog_article->alias]) }}"> <h4><?=$blog_article->title;?></h4> </a>
                            <p><?=$blog_article->desctext;?></p>
                            <span class=" article-date-create">
                                <p class="date">
                                    <span class="month"><?=date('M');?></span> <!--date( 'F d, Y' );-->
                                    <span class="day"><?=date('d');?></span>
                                </p>
                            </span>
                            <div class="article-panel-info">
                                <ul>
                                    <li>Add: <span class="article-user-info"><?=$blog_article->users->name;?></span> </li>
                                    <a href="{{ route('articles_cat', ['cat' => $blog_article->articlesCategories->alias]) }}"> <li><?=$blog_article->articlesCategories->title;?></li> </a>  <!--href="cat/computers"-->
                                    <a href="{{ route('articles.show', ['alias' => $blog_article->alias]) }}#respond"> <li><?=( count($blog_article->comments) ) ? count($blog_article->comments) : 'No Comments';?></li> </a>
                                    <a href="{{ route('articles.show', ['alias' => $blog_article->alias]) }}" type="button" class="btn btn-primary article-btn-readmore">
                                        <?=( App::getLocale() == 'en' ) ? 'Read More' : trans('custom_ru.btn_read_more');?>
                                    </a>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 article-img" data-toggle="modal" data-target="#target_modal_window_<?=$blog_article->id;?>">
                            <img src="<?=asset('img/blog_images/'.json_decode($blog_article->images)->mini);?>" alt="<?=$blog_article->alias;?>">
                         </div>
                    </div> <!--/.row-->

                    <!--Modal Window-->
                    <div class="modal fade" id="target_modal_window_<?=$blog_article->id;?>" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                     <h4 class="modal-title"> <i class="fa fa-pencil" style="font-size:24px"></i>... <?=$blog_article->title;?> </h4>
                                </div>
                                <div class="modal-body">
                                    <img src="<?=asset('img/blog_images/'.json_decode($blog_article->images)->max);?>" alt="<?=$blog_article->alias;?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Modal Window-->
                </li>
                <?php endforeach;?>
            </ul>
            <?php else:?>
                <h2>No Blog articles!</h2>
            <?php endif;?>
        </div> <!--/.col-*-->
        <!--/BlogList-->

        <!--Right Side-bar-->
        <?=$right_sidebar_content;?>
        <!--Right Side-bar-->

        <!--Pagination-->
        <?php if( is_a($blog_articles, 'Illuminate\Pagination\LengthAwarePaginator') ): ?>
            <div class="row">
            <?php if( $blog_articles->lastPage() > 1 ): ?> <!--`lastPage()` даст номер последней страницы,кот.определил Laravel для пагинации,и,если она более чем 1, то стоит в принципе ее выводить-->
                <div class="col-lg-12 col-md-12 text-center custom-pagination">{{ $blog_articles->links() }}</div>
                <?php endif;?>
            </div>
        <?php endif;?>
        <!--/Pagination-->

    </div> <!--/.container-fluid-->
</div> <!--/#bloglist_anchor_section-->
<!-- /BlogList Section -->