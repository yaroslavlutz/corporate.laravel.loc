<div id="block_add_article" class="block-add-entries">
    <div class="container-fluid">
        <h2 style="color:#43166d;">Add New Article</h2>

        <form class="form-horizontal" name="add_entries_form" action="{{ route('admin_articles_add_new') }}" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="article_alias_input" class="control-label col-sm-2">Alias of Article:</label>
                <div class="col-sm-8">
                    <input type="text" name="article_alias_input" id="article_alias_input"  value="{{ old('article_alias_input') }}" class="form-control <?=($errors->has('article_alias_input')) ? 'input-error' : '';?>" placeholder="Alias of Article" />
                    @if ($errors->has('article_alias_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_alias_input') }} </span> @endif 
                </div>
            </div>
            <div class="form-group">
                <label for="article_title_input" class="control-label col-sm-2">Title of Article:</label>
                <div class="col-sm-8">
                    <input type="text" name="article_title_input" id="article_title_input"  value="{{ old('article_title_input') }}" class="form-control <?=($errors->has('article_title_input')) ? 'input-error' : '';?>" placeholder="Title of Article" />
                    @if ($errors->has('article_title_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_title_input') }} </span> @endif  
                </div>
            </div>
            <div class="form-group">
                <label for="article_category_select" class="control-label col-sm-2">Select Category of Article:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="article_category_select" id="article_category_select">
                    <?php foreach( $article_categories as $key => $collect_article_cat ):?>
                        <?php if( $key !== 0 ): break; endif;?> 

                        <?php foreach( $collect_article_cat as $article_cat ):?>
                            <optgroup label="<?=$article_cat->title;?>">

                                <option value="<?=$article_cat->id;?>"><?=$article_cat->title;?></option>
                            <?php if( isset( $article_categories[$article_cat->id] ) ) { ?>
                                <?php foreach( $article_categories[$article_cat->id] as $item_sub_categ ) { ?>
                                    <option value="<?=$item_sub_categ->id;?>"><?=$item_sub_categ->title;?></option>
                                <?php } ?>
                            <?php } ?>

                            </optgroup>
                        <?php endforeach;?> 
                    <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="article_user_select" class="control-label col-sm-2">Select User of Article:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="article_user_select" id="article_user_select">
                        <?php foreach( $all_users as $item_user ):?>
                            <option value="<?=$item_user['id'];?>"><?=$item_user['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="article_text_input_ckeditor" class="control-label col-sm-2">Text of Article:</label>
                <div class="col-sm-8 <?=($errors->has('article_text_input_ckeditor')) ? 'input-error' : '';?>">
                    <textarea rows="5" name="article_text_input_ckeditor" id="article_text_input_ckeditor" class="form-control" placeholder="Text of Article">
                        {{ old('article_text_input_ckeditor') }}
                    </textarea>
                    @if ($errors->has('article_text_input_ckeditor')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_text_input_ckeditor') }} </span> @endif 
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
                    @if ($errors->has('article_image_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('article_image_input') }} </span> @endif 
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_add_article" id="btn_submit_add_article">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add new Article
                    </button>
                </div>
            </div>
        </form>
    </div> <!--/.container-fluid -->
</div>
