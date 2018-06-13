<?php
//dump($right_sidebar_content);
//dump($single_article);
//dump($single_article[0]->comments);
//dump( $single_article[0]->comments->groupBy('parent_comment_id') );

/* Получим данные Юзера,если он зарегин и авторизирован, иначе NULL. ($if_current_user_registered->id/$if_current_user_registered->name/$if_current_user_registered->email) */
$if_current_user_registered = Auth::user();  //также можно использовать конструкцию: if( Auth::check() ) { //вернет TRUE если юзер авторизировался в данный момент }
/*Делаем динамическими классы Bootstrap, в зависимости от того передается сюда в макет Side-bar или нет. Если сайт бар определен,то колонки смежной с Side-bar`ом секции будут `9` иначе будут на всю ширину- `12` */
( $right_sidebar_content ) ? $class_num = 9 : $class_num = 12;
?>

<!-- Single article Section -->
<div id="singlearticle_anchor_section" class="singlearticle-section" style="margin-top:145px;">
    <div class="container-fluid">
        <h1 class="wow slideInLeft" data-wow-duration="2.5s" data-wow-delay="0.3s" data-wow-offset="120">
            <a href="" style="text-transform:uppercase; color:gray; text-decoration:none;"> <?=$single_article[0]->title;?> </a>
        </h1>
        <p class="wow slideInLeft" data-wow-duration="3.5s" data-wow-delay="0.5s" data-wow-offset="120" style="font-size:15px;"> <?=$single_article[0]->title;?> </p>

        <!--Single article-->
        <div class="col-lg-<?=$class_num;?> col-md-<?=$class_num;?>">

            <?php if( isset($single_article) && is_object($single_article) ): ?>
            <ul id="ul_single_article" class="ul-single-article">
                <li id="li_single_article_id_<?=$single_article[0]->id;?>" class="li-single-article"
                    data-alias="<?=$single_article[0]->alias;?>"
                    data-articlescat="<?=$single_article[0]->articlesCategories->alias;?>"
                    data-userid="<?=$single_article[0]->users->name;?>">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 article-img">
                            <a href=""> <h4 class="text-center"><?=$single_article[0]->title;?></h4> </a>
                            <img src="<?=asset('img/blog_images/'.json_decode($single_article[0]->images)->origin);?>" alt="<?=$single_article[0]->alias;?>">
                            <p class="date">
                                <span class="month"><?=date( 'M', strtotime($single_article[0]->created_at) );?></span>
                                <span class="day"><?=date( 'd', strtotime($single_article[0]->created_at) );?></span>
                            </p>
                        </div>
                        <div class="col-lg-12 col-md-12 article-desc">
                            <div class="article-desc-text"><?=$single_article[0]->fulltext;?></div>
                            <div class="article-panel-info text-center">
                                <ul>
                                    <li>Add: <span class="article-user-info"><?=$single_article[0]->users->name;?></span> </li>
                                    <a href="{{ route('articles_cat', ['cat' => $single_article[0]->articlesCategories->alias]) }}"> <li><?=$single_article[0]->articlesCategories->title;?></li> </a>
                                    <a href="#respond"> <li><?=( count($single_article[0]->comments) ) ? count($single_article[0]->comments) : 'No Comments';?></li> </a>
                                    <a href="{{ route('articles') }}" type="button" class="btn btn-primary article-btn-readmore">
                                        <?=( App::getLocale() == 'en' ) ? 'See all articles' : trans('custom_ru.see_all_articles');?>
                                    </a>
                                </ul>
                            </div>
                        </div>

                    </div> <!--/.row-->
                </li>
            </ul>
            <?php endif;?>


            <!--Comments block-->
            <?php /* Сгрупированные Комментарии по полю `parent_comment_id`,что дает представление о их иерархии - о том есть ли коммент родительского уровня или это комментарий на комментарий */
                $commentsGroupByParent = $single_article[0]->comments->groupBy('parent_comment_id');
                //$commentsGroupByParent будет доступна,как и др.перемен.в этом файле,в шаблоне для Комментариев `__comments_single_article`
            ?>
             @include( 'frontendsite.'.env('THEME').'.include.__comments_single_article')
            <!--/Comments block-->

            <!--Add comment form (for parent level comment)-->
            @include( 'frontendsite.'.env('THEME').'.include.__form_add_comment_single_article')
            <!--/Add comment form (for parent level comment)-->

        </div> <!--/.col-*-->
        <!--Single article-->

        <!--Right Side-bar-->
        <?=$right_sidebar_content;?>
        <!--Right Side-bar-->

    </div> <!--/.container-fluid-->
</div> <!--/#bloglist_anchor_section-->
<!-- /Single article Section -->