<li id="li_article_comment_id_" class="li-article-comment if-comment-author"
    data-comment-id="<?=$dataforViewOneCommentAjax['this_comment_id'];?>"
    data-parent-comment-id="<?=$dataforViewOneCommentAjax['parent_comment_id'];?>"
    data-article-id="<?=$dataforViewOneCommentAjax['article_id'];?>" style="background:#ffff1c;">
    <div class="col-lg-1 col-md-1 comment-user-ava">
        <img src="https://www.gravatar.com/avatar/<?=md5($dataforViewOneCommentAjax['user_email']);?>?d=mm&s=75" alt="default Gravatar" style="outline:1px solid #afaeae; margin-left:9px;">
    </div>
    <div class="col-lg-11 col-md-11 comment-text-content">
        <p class="comment-text-content-user"><?=$dataforViewOneCommentAjax['user_name'];?> -
            <span><?=date( 'F d, Y (H:i)');?></span>
        </p>
        <p class="comment-text-content-text"><?=$dataforViewOneCommentAjax['this_comment_text'];?></p>
    </div>
</li>
