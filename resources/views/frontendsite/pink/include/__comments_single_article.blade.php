<?php
//dump($commentsGroupByParent);
$userObject = new \App\User();
?>
<div class="col-lg-12 col-md-12 article-comment">
    <h2><?=( App::getLocale() == 'en' ) ? 'Comments of article' : trans('custom_ru.comments_of_article');?>
        <span class="label label-info"><?=( count($single_article[0]->comments) ) ? count($single_article[0]->comments) : '0';?></span>&nbsp;:
    </h2>

    <ul id="ul_article_comment" class="ul-article-comment">
    <?php foreach( $commentsGroupByParent as $key => $collect_comments ):?>
        <?php if( $key !== 0 ): break; endif;?> <!--Комменты родит.уровня иммеют ключ(в сгруппированном массиве $commentsGroupByParent по полю`parent_comment_id`) = 0. Значит,если $key !== 0 - выходим из цикла,т.к.это не коммент родит.уровня-->

            <!--Выводим Комментарии родительского уровня-->
            <?php $indexNumPar = 0;?>
            <?php foreach( $collect_comments as $item_comment ):?>  <!--Loop for Комментарии родительского уровня-->
            <li id="li_article_comment_id_<?=$item_comment->id;?>" class="li-article-comment if-comment-author-<?=( $item_comment->user_id == $single_article[0]->users->id )?'true':'false';?>"
                data-comment-id="<?=$item_comment->id;?>"
                data-parent-comment-id="<?=$item_comment->parent_comment_id;?>"
                data-article-id="<?=$item_comment->article_id;?>">
                <div class="col-lg-1 col-md-1 comment-user-ava">
                    <?php if( $item_comment->user_id != NULL ): $u_email_grav = 'default@mail.com'; else: $u_email_grav = $item_comment->email; endif;?>
                    <img src="https://www.gravatar.com/avatar/<?=md5($u_email_grav);?>?d=mm&s=75" alt="default Gravatar" style="outline:1px solid #afaeae; margin-left:9px;">
                </div>
                <div class="col-lg-11 col-md-11 comment-text-content">
                    <p class="comment-text-content-user"><?=( $item_comment->user_id != NULL ) ? $userObject::find( $item_comment->user_id )->name : $item_comment->name;?> -
                        <span><?=date( 'F d, Y (H:i)', strtotime($item_comment->created_at) );?></span>
                    </p>
                    <p class="comment-text-content-text"><?=$item_comment->text;?></p>
                    <a href="" type="button" class="btn btn-info article-btn-comments-form" data-toggle="modal" data-target="#target_modalwindow_comment_<?=$item_comment->id;?>">
                        <?=( App::getLocale() == 'en' ) ? 'Reply' : trans('custom_ru.reply_comment');?>
                    </a>
                </div>
                <span class="label label-default" style="position:absolute;right:20px;margin-top:-10px;font-size:13px;"><?=($indexNumPar+1);?></span>
            </li>
            <?php $indexNumPar++;?>

            <!--Modal Window form for comment on parent comment-->
            <div class="modal fade" id="target_modalwindow_comment_<?=$item_comment->id;?>" role="dialog" data-comment-id="<?=$item_comment->id;?>">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> <i class="fa fa-pencil" style="font-size:24px"></i>..... </h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12 col-md-12" style="margin:10px 0 25px 0;">
                                <form class="form-horizontal" id="comment_on_article_form_ch" name="comment_on_article_form_ch" action="{{ route('comment.store') }}" method="post" novalidate> <!-- <?//='/contact');?> Or <?//=route('contact');?> -->
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <label for="comment_user_name" style="display:none;">Name:</label>
                                        <input type="text" class="form-control" id="comment_user_name" placeholder="Enter Name" name="comment_user_name"
                                               value="<?=($if_current_user_registered) ? $if_current_user_registered->name : '';?>" <?=($if_current_user_registered) ? 'disabled' : '';?> />
                                    </div>
                                    <div class="form-group">
                                        <label for="comment_user_email" style="display:none;">Email:</label>
                                        <input type="email" class="form-control" id="comment_user_email" placeholder="Enter Email" name="comment_user_email"
                                               value="<?=($if_current_user_registered) ? $if_current_user_registered->email : '';?>" <?=($if_current_user_registered) ? 'disabled' : '';?> />
                                    </div>
                                    <div class="form-group">
                                        <label for="comment_user_site" style="display:none;">Site:</label>
                                        <input type="text" class="form-control" id="comment_user_site" placeholder="Enter Site" name="comment_user_site"
                                               value="<?=($if_current_user_registered) ? 'http://site-user.ru' : '';?>" <?=($if_current_user_registered) ? 'disabled' : '';?> />
                                    </div>
                                    <div class="form-group">
                                        <label for="comment_user_text" style="display:none;">Text:</label>
                                        <textarea class="form-control" id="comment_user_text" name="comment_user_text" rows="3" placeholder="Your comment ..."></textarea>
                                    </div>

                                    <input type="hidden" id="comment_article_id" name="comment_article_id" value="<?=$single_article[0]->id;?>"> <!--date("F j, Y, g:i a")-->
                                    <input type="hidden" id="comment_parent_comment_id" name="comment_parent_comment_id" value="<?=$item_comment->id;?>">
                                    <input type="hidden" id="comment_user_id" name="comment_user_id" value="<?=($if_current_user_registered) ? $if_current_user_registered->id : NULL;?>">

                                    <button type="submit" class="btn btn-info article-btn-comments-form">leave a comment</button>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:none;">{{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}</div>
                    </div>
                </div>
            </div>
            <!--/Modal Window form for comment on parent comment->

                <!--Выводим дочерние Комментарии для текущего родит.Комментария, если они есть-->
                <?php if( isset( $commentsGroupByParent[$item_comment->id] ) ):?> <!--Проверяем есть ли дочерние Комменты к текущему род.Комменту по проверке наличия номера такой ячейки в группированной выборке в $commentsGroupByParent-->
                <ul id="ul_article_subcomment" class="ul-article-subcomment">
                    <?php foreach( $commentsGroupByParent[$item_comment->id] as $item_sub_comment ):?>
                    <li id="li_article_comment_id_<?=$item_sub_comment->id;?>" class="li-article-comment if-comment-author-<?=( $item_sub_comment->user_id == $single_article[0]->users->id )?'true':'false';?>"
                        data-comment-id="<?=$item_sub_comment->id;?>"
                        data-parent-comment-id="<?=$item_sub_comment->parent_comment_id;?>"
                        data-article-id="<?=$item_sub_comment->article_id;?>">
                        <div class="col-lg-1 col-md-1 comment-user-ava">
                            <?php if( $item_sub_comment->user_id != NULL ): $u_email_grav = 'default@mail.com'; else: $u_email_grav = $item_sub_comment->email; endif;?>
                            <img src="https://www.gravatar.com/avatar/<?=md5($u_email_grav);?>?d=mm&s=75" alt="default Gravatar" style="outline:1px solid #afaeae; margin-left:9px;">
                        </div>
                        <div class="col-lg-11 col-md-11 comment-text-content">
                            <p class="comment-text-content-user"><?=( $item_sub_comment->user_id != NULL ) ? $userObject::find( $item_sub_comment->user_id )->name : $item_sub_comment->name;?> -
                                <span><?=date( 'F d, Y (H:i)', strtotime($item_sub_comment->created_at) );?></span>
                            </p>
                            <p class="comment-text-content-text"><?=$item_sub_comment->text;?></p>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <!--/Выводим дочерние Комментарии для текущего родит.Комментария, если они есть-->

            <!--/Выводим Комментарии родительского уровня-->
            <?php endforeach;?> <!--Loop for Комментарии родительского уровня-->
    <?php endforeach;?>
    </ul>
</div> <!--/.col-lg-* .article-comment-->
<!-- $userObject::find( $item_comment->user_id )->name -->