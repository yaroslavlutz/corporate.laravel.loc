<?php
//dump($all_articles);
?>
<!-- Articles Section -->
<div id="article_anchor_section" class="article-section" style="margin-top:22px;">
    <div class="container-fluid">

        <h2>All Articles:</h2>

        <?php if( isset($all_articles) && is_object($all_articles) ):?>
        <table class="table table-bordered table-with-article-list">
            <thead class="text-center">
            <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">ALIAS</th>
                <th style="text-align: center;">TITLE</th>
                <th style="text-align: center;">TEXT</th>
                <th style="text-align: center;">IMAGE</th>
                <th style="text-align: center;">CATEGORY</th>
                <th style="text-align: center;">USER</th>
                <th style="text-align: center;">CREATED <sub>(Y-M-D Time)</sub> </th>
                <th style="text-align: center;">DELETE</th>
            </tr>
            </thead>
            <tbody>
            <?php $index=1; ?>
            <?php foreach( $all_articles as $i_article):?>
            <tr>
                <td> <strong><?=$index++;?></strong> </td>
                <td><?=$i_article->id;?></td>
                <td><?=$i_article->alias;?></td>
                <td> <a href="{{ route('admin_articles_edit',['alias'=>$i_article->alias]) }}" data-toggle="tooltip" data-placement="right" title="Edit this article"><?=$i_article->title;?></a> </td>
                <td> <?=str_limit($i_article->desctext, 190);?></td>
                <td> <img src="<?=asset('img/blog_images/'.json_decode($i_article->images)->mini);?>" alt="<?=$i_article->alias;?>" style="width:100%;height:auto;" /> </td>
                <td><?=$i_article->articlesCategories->title;?></td>
                <td><?=$i_article->users->name;?></td>
                <td><?=$i_article->created_at;?></td>

                <td style="text-align: center;">
                    <form class="form-horizontal" name="admin_delete_article" action="{{ route('admin_articles_delete',['alias'=>$i_article->alias]) }}" method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <input type="hidden" name="_method" value="delete"> это скрытое поле для того,чтобы осуществить REST-метод DELETE - `public function destroy()` в `app/Http/Controllers/Admin/ArticleResourceController.php`. Строка ниже генерирует тоже самое -->
                        {{ method_field('delete') }}

                        <div class="form-group">
                            <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                                <button type="submit" class="btn btn-sm btn-danger" name="btn_submit_contact_us_home_form" id="btn_submit_contact_us_home_form" data-toggle="tooltip" data-placement="top" title="Delete this entry" style="line-height:0.8; padding-left:20px; padding-right:20px;">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12 text-center">
                <a type="button" class="btn-success btn-lg" href="{{ route('admin_articles_create') }}" style="display:block;margin-bottom:22px;"> <span class="glyphicon glyphicon-plus-sign"></span> Add New Article</a>
            </div>
        </div>

    </div> <!--/.container-fluid-->
</div> <!--/#article_anchor_section-->
<!-- /Articles Section -->