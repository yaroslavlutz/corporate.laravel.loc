<?php
//dump($all_menus);
?>
<!-- Articles Section -->
<div id="menu_anchor_section" class="menus-section" style="margin-top:22px;">
    <div class="container-fluid">

        <h2>All Articles:</h2>

        <?php if( isset($all_menus) && is_array($all_menus) ):?>
        <table class="table table-bordered table-with-article-list">
            <thead class="text-center">
            <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">TITLE</th>
                <th style="text-align: center;">URL_PATH</th>
                <th style="text-align: center;">DELETE</th>
            </tr>
            </thead>
            <tbody>
            <?php $index=1; ?>
            <?php foreach( $all_menus as $i_menu):?>
            <tr>
                <td> <strong><?=$index++;?></strong> </td>
                <td style="font-weight:bold;"> <a href="{{ route('admin_menus_edit',['menu'=>$i_menu['id']]) }}" data-toggle="tooltip" data-placement="right" title="Edit this menu"><?=$i_menu['title'];?></a> </td>
                <td><?=$i_menu['url_path'];?></td>

                <td style="text-align:center;">
                    <form class="form-horizontal" name="admin_delete_menu" action="{{ route('admin_menus_delete',['menu'=>$i_menu['id']]) }}" method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <input type="hidden" name="_method" value="delete"> это скрытое поле для того,чтобы осуществить REST-метод DELETE - `public function destroy()` в `app/Http/Controllers/Admin/MenuResourceController.php`. Строка ниже генерирует тоже самое -->
                        {{ method_field('delete') }}

                        <div class="form-group">
                            <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                                <button type="submit" class="btn btn-sm btn-danger" name="btn_submit_admin_delete_menu" id="id_btn_submit_admin_delete_menu" data-toggle="tooltip" data-placement="top" title="Delete this Menu" style="line-height:0.8; padding-left:20px; padding-right:20px;">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>

            <?php if( isset($i_menu['submenu']) ) {?> <!--если это дочерние.пункты меню,с дополнительным элементом массива "submenu",кот.является тоже массивом,то выводим их-->
                <?php foreach( $i_menu['submenu'] as $i_submenu):?>
                <tr>
                    <td> <strong><?=$index++;?></strong> </td>
                    <td style="padding-left:22px !important;"> — <a href="{{ route('admin_menus_edit',['menu'=>$i_submenu['id']]) }}" data-toggle="tooltip" data-placement="right" title="Edit this menu"><?=$i_submenu['title'];?></a> </td>
                    <td><?=$i_submenu['url_path'];?></td>

                    <td style="text-align: center;">
                        <form class="form-horizontal" name="admin_delete_menu" action="{{ route('admin_menus_delete',['menu'=>$i_submenu['id']]) }}" method="post" novalidate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <!-- <input type="hidden" name="_method" value="delete"> это скрытое поле для того,чтобы осуществить REST-метод DELETE - `public function destroy()` в `app/Http/Controllers/Admin/MenuResourceController.php`. Строка ниже генерирует тоже самое -->
                            {{ method_field('delete') }}

                            <div class="form-group">
                                <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                                    <button type="submit" class="btn btn-sm btn-danger" name="btn_submit_admin_delete_menu" id="id_btn_submit_admin_delete_menu" data-toggle="tooltip" data-placement="top" title="Delete this Menu" style="line-height:0.8; padding-left:20px; padding-right:20px;">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                <?php endforeach;?>
            <?php }?>

            <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12 text-center">
                <a type="button" class="btn-success btn-lg" href="{{ route('admin_menus_create') }}" style="display:block;margin-bottom:22px;"> <span class="glyphicon glyphicon-plus-sign"></span> Add New Item Menu</a>
            </div>
        </div>

    </div> <!--/.container-fluid-->
</div> <!--/#article_anchor_section-->
<!-- /Articles Section -->