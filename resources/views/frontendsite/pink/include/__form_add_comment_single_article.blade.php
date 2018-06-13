<div class="col-lg-12 col-md-12" style="margin:10px 0 25px 0;">
    <div id="block-result-info" class="block-result-info"></div> <!--Блок для вывода информации Юзеру о произошедших действиях с формой отправки данного Комментария-->

    <h4>Leave your comment, please</h4>
    <form class="form-horizontal" id="comment_on_article_form" name="comment_on_article_form" action="{{ route('comment.store') }}" method="post" novalidate> <!--Маршрут на обработчик данных этой Формы-->
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
        <input type="hidden" id="comment_parent_comment_id" name="comment_parent_comment_id" value="0">
        <input type="hidden" id="comment_user_id" name="comment_user_id" value="<?=($if_current_user_registered) ? $if_current_user_registered->id : NULL;?>">

        <button type="submit" class="btn btn-info article-btn-comments-form">leave a comment</button>
    </form>
</div> <!--/.col-*-->
