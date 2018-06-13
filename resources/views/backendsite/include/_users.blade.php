<?php
//dump($all_users);
?>
<!-- Articles Section -->
<div id="menu_anchor_section" class="menus-section" style="margin-top:22px;">
    <div class="container-fluid">

        <h2>All Articles:</h2>

        <?php if( isset($all_users) && is_object($all_users) ):?>
        <table class="table table-bordered table-with-article-list">
            <thead class="text-center">
            <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">NAME</th>
                <th style="text-align: center;">EMAIL</th>
                <th style="text-align: center;">ROLE</th>
                <th style="text-align: center;">DELETE</th>
            </tr>
            </thead>
            <tbody>
            <?php $index=1; ?>
            <?php foreach( $all_users as $i_user):?>
            <tr class="text-center">
                <td> <strong><?=$index++;?></strong> </td>
                <td><?=$i_user->id;?></td>
                <td> <a href="{{ route('admin_users_edit',['id'=>$i_user->id]) }}" data-toggle="tooltip" data-placement="right" title="Edit this User"><?=$i_user->name;?></a> </td>
                <td><?=$i_user->email;?></td>
                <td>
                <?php if( count($i_user->roles()->get()) > 1 ):?> <!--если User имеет не одну роль,а несколько,то выводим их списком для него-->
                    <ul style="list-style-type:none; padding-left:0;">
                        <?php foreach( $i_user->roles()->get() as $i_roles):?>
                        <li><?=$i_roles->name;?></li>
                        <?php endforeach;?>
                    </ul>
                <?php else:?> <!--иначе для User`a выводим его одну единственную роль-->
                    <?=$i_user->roles()->get()[0]->name;?>
                <?php endif;?>
                </td>

                <td style="text-align: center;">
                    <form class="form-horizontal" name="admin_delete_user" action="{{ route('admin_users_delete',['id'=>$i_user->id]) }}" method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- <input type="hidden" name="_method" value="delete"> это скрытое поле для того,чтобы осуществить REST-метод DELETE - `public function destroy()` в `app/Http/Controllers/Admin/UserResourceController.php`. Строка ниже генерирует тоже самое -->
                        {{ method_field('delete') }}

                        <div class="form-group">
                            <div class="col-lg-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80">
                                <button type="submit" class="btn btn-sm btn-danger" name="btn_submit_admin_delete_user" id="id_btn_submit_admin_delete_user" data-toggle="tooltip" data-placement="top" title="Delete this User" style="line-height:0.8; padding-left:20px; padding-right:20px;">
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
                <a type="button" class="btn-success btn-lg" href="{{ route('admin_users_create') }}" style="display:block;margin-bottom:22px;"> <span class="glyphicon glyphicon-plus-sign"></span> Add New User</a>
            </div>
        </div>

    </div> <!--/.container-fluid-->
</div> <!--/#article_anchor_section-->
<!-- /Articles Section -->