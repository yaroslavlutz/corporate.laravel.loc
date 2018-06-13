<?php
//dump($current_article_data);
//dump($article_categories); - Данные для Categories of articles
//dump($all_users); - Данные для Users
?>
<div id="block_edit_article" class="block-add-entries">
    <div class="container-fluid">
        <h2 style="color:#43166d;"> <i>Editing an Article</i> - <?=( isset($current_article_data) ) ? '<b>'.$current_article_data[0]['title'].'</b> (ID:' .$current_article_data[0]['id'].')' : '';?></h2>

        <form class="form-horizontal" name="edit_entries_form" action="{{ route('admin_articles_update',['alias' => $current_article_data[0]['alias']]) }}" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT"> <!--необходимо,чтобы осуществить REST-метод и чтобы отработал наш метод `public function update()` в `app/Http/Controllers/Admin/ArticleResourceController.php`-->

            <div class="form-group">
                <label for="article_alias_input" class="control-label col-sm-2">Alias of Article:</label>
                <div class="col-sm-8">
                    <input type="text" name="article_alias_input" id="article_alias_input"  value="<?=( isset($current_article_data) ) ? $current_article_data[0]['alias'] : '';?>" class="form-control <?=($errors->has('article_alias_input')) ? 'input-error' : '';?>" placeholder="Alias of Article" />
                    @if ($errors->has('article_alias_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_alias_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>

            <div class="form-group">
                <label for="article_title_input" class="control-label col-sm-2">Title of Article:</label>
                <div class="col-sm-8">
                    <input type="text" name="article_title_input" id="article_title_input"  value="<?=( isset($current_article_data) ) ? $current_article_data[0]['title'] : '';?>" class="form-control <?=($errors->has('article_title_input')) ? 'input-error' : '';?>" placeholder="Title of Article" />
                    @if ($errors->has('article_title_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_title_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>

            <div class="form-group">
                <label for="article_category_select" class="control-label col-sm-2">Select Category of Article:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="article_category_select" id="article_category_select">
                    <?php foreach( $article_categories as $key => $collect_article_cat ):?>
                        <?php if( $key !== 0 ): break; endif;?> <!--Категории Статей родит.уровня иммеют ключ(в сгруппированном массиве $article_categories по полю`parent_cat_id`) = 0. Значит,если $key !== 0 - выходим из цикла,т.к.это не коммент родит.уровня-->

                        <!--Выводим Категории Статей родительского уровня-->
                        <?php foreach( $collect_article_cat as $article_cat ):?>  <!--Loop for Категории Статей родительского уровня-->
                            <optgroup label="<?=$article_cat->title;?>">

                                <option value="<?=$article_cat->id;?>" <?=($article_cat->id == $current_article_data[0]['articles_category_id']) ? 'selected' : '';?>> <?=$article_cat->title;?> </option>
                            <?php if( isset( $article_categories[$article_cat->id] ) ) { ?> <!--<!--Проверяем есть ли дочерние Категории Статей по проверке наличия номера такой ячейки в группированной выборке в $article_categories-->
                                <!--Выводим дочерние Категории Статей для текущего родит.Комментария, если они есть-->
                                <?php foreach( $article_categories[$article_cat->id] as $item_sub_categ ) { ?>
                                    <option value="<?=$item_sub_categ->id;?>" <?=($item_sub_categ->id == $current_article_data[0]['articles_category_id']) ? 'selected' : '';?>> <?=$item_sub_categ->title;?> </option>
                                <?php } ?>
                                <!--/Выводим дочерние Категории Статей для текущего родит.Комментария, если они есть-->
                            <?php } ?>

                            </optgroup>
                        <?php endforeach;?> <!--Loop for Категории Статей родительского уровня-->
                        <!--/Выводим Категории Статей родительского уровня-->
                    <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="article_user_select" class="control-label col-sm-2">Select User of Article:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="article_user_select" id="article_user_select">
                        <?php foreach( $all_users as $item_user ):?>
                            <option value="<?=$item_user['id'];?>" <?=($item_user['id'] == $current_article_data[0]['user_id']) ? 'selected' : '';?>> <?=$item_user['name'];?> </option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="article_text_input_ckeditor" class="control-label col-sm-2">Text of Article:</label>
                <div class="col-sm-8 <?=($errors->has('article_text_input_ckeditor')) ? 'input-error' : '';?>">
                    <textarea rows="5" name="article_text_input_ckeditor" id="article_text_input_ckeditor" class="form-control" placeholder="Text of Article">
                        <?=( isset($current_article_data) ) ? $current_article_data[0]['fulltext'] : '';?>
                    </textarea>
                    @if ($errors->has('article_text_input_ckeditor')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_text_input_ckeditor') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>

            <div class="form-group">
                <label for="page_new_image_input" class="control-label col-sm-2">Current Image of Article:</label>
                <div class="col-sm-8">
                    <input type="hidden" name="article_current_image" id="article_current_image" class="form-control" value="" />
                    <div class="col-sm-4">
                        <?php if( $current_article_data[0]['images'] && $current_article_data[0]['images'] != '' ): ?>
                        <img class="img-responsive" src="<?=asset('img/blog_images/'.json_decode($current_article_data[0]['images'])->mini);?>" alt="<?=$current_article_data[0]['alias'];?>" alt="image" width="100%" height="auto">
                        <?php endif;?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="article_image_input" class="control-label col-sm-2">Image of Page:</label>
                <div class="col-sm-8">
                    <input type="file" name="article_image_input" id="article_image_input" class="form-control filestyle" value="{{ old('article_image_input') }}"
                           data-buttonName="btn-primary"
                           data-buttonText="Choose file +"
                           data-iconName="glyphicon glyphicon-folder-open"
                           data-buttonBefore="false"
                           data-badge="true"
                           data-disabled="false"
                           data-placeholder="No file uploaded"/>
                    @if ($errors->has('article_image_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_image_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>
            <input type="hidden" name="article_current_image_input" id="article_current_image_input" class="form-control" value="<?=( isset($current_article_data[0]['images']) ) ? $current_article_data[0]['images'] : '';?>" />

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_add_article" id="btn_submit_add_article">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Update this Article
                    </button>
                </div>
            </div>
        </form>
    </div> <!--/.container-fluid -->
</div>