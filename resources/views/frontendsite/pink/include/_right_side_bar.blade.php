<?php
//dump($portfolios);
//dump($articles);
//dump($comments);

?>
<div id="right_side_bar" class="col-lg-3 col-md-3 right-side-bar">
    <!--Show last Portfolio-->
    <h3 class="text-center">
        <?=( App::getLocale() == 'en' ) ? 'Latest Portfolios' : trans('custom_ru.latest_portfolios');?>:
    </h3>
    <ul class="list-side-bar list-portfolio-side-bar text-center">
        <?php if( isset($portfolios) && is_array($portfolios) ): ?>
            <?php foreach( $portfolios as $portfolio ): ?>
                <li id="portfolio_side_bar_id_<?=$portfolio['alias'];?>">
                    <a href="{{ route( 'portfolios.show', ['alias' => $portfolio['alias']] ) }}"><?=$portfolio['title'];?></a>
                    &nbsp;<span style="font-size:11px;"> <?=date( 'F d, Y', strtotime($portfolio['created_at']) );?> </span>
                </li>
            <?php endforeach;?>
        <?php endif; ?>
    </ul>
    <!--/Show last Portfolio-->

    <!--Show last Articles of Blog-->
    <h3 class="text-center">
        <?=( App::getLocale() == 'en' ) ? 'Latest Blog articles' : trans('custom_ru.latest_blog_articles');?>:
    </h3>
    <ul class="list-side-bar list-article-side-bar text-center">
        <?php if( isset($articles) && is_array($articles) ): ?>
        <?php foreach( $articles as $article ): ?>
        <li id="article_side_bar_id_<?=$article['id'];?>" data-alias="<?=$article['alias'];?>">
            <a href="{{ route( 'articles.show', ['alias' => $article['alias']] ) }}"><?=$article['title'];?></a>
            &nbsp;<span style="font-size:11px;"> <?=date( 'F d, Y', strtotime($article['created_at']) );?> </span>
        </li>
        <?php endforeach;?>
        <?php endif; ?>
    </ul>
    <!--/Show last Articles of Blog-->

    <!--Show last Comments-->
    <?php if( isset($comments) ): ?>
    <h3 class="text-center">
        <?=( App::getLocale() == 'en' ) ? 'Latest Comments' : trans('custom_ru.latest_comments');?>:
    </h3>
    <ul class="list-side-bar list-comment-side-bar text-center">
        <?php foreach( $comments as $comment ): ?>
        <li id="comment_side_bar_id_<?=$comment['id'];?>" data-parent-id="<?=$comment['parent_comment_id'];?>">
            <a href="{{ route( 'articles.show', ['alias' => $comment['articles']['alias']] ) }}"><?=str_limit($comment['articles']['title'], 30);?></a>
            <span style="font-size:11px;"> <?=date( 'F d, Y', strtotime($comment['created_at']) );?> </span>
            <span style="font-size:11px; font-weight:bold;"> ( From: <?=( is_array($comment['users']) && $comment['users'] != NULL ) ? $comment['users']['name'] : $comment['name'];?> ) </span>
            <img src="https://www.gravatar.com/avatar/<?=md5($comment['users']['email']);?>?d=mm&s=55" alt="default Gravatar" style="outline:1px solid #afaeae; margin-left:9px;">
        </li>
        <?php endforeach;?>
    </ul>
    <?php endif; ?>
    <!--/Show last Comments-->

</div> <!--/#right_side_bar-->