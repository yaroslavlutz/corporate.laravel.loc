<!-- Permissions Section -->
<div id="permission_anchor_section" class="permission-section" style="margin-top:22px;">
    <div class="container-fluid">

        <h2> <b>Roles</b> of Users and <b>Permissions</b>:</h2>

        <div style="font-size:11px; margin-left:52px;"> <b>PERMISSIONS (DB table `permissions`):</b>
            <ul>
                <li>VIEW_ADMIN_PANEL - просматривать Гл.страницу Админ-панели</li>
                <li>ADD_MATERIAL - добавлять новый материал</li>
                <li>UPDATE_MATERIAL - обновлять/редактировать материал</li>
                <li>DELETE_MATERIAL - удалять материал</li>
                <li>ADD_USERS - добавлять нового Юзера</li>
                <li>UPDATE_USERS - обновлять/редактировать Юзера</li>
                <li>DELETE_USERS - удалять Юзера</li>
            </ul>
        </div>

        <form class="form-horizontal" name="edit_entries_form" action="{{ route('admin_permissions_add_new') }}" method="post" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="short-table white">
                <table class="table table-bordered" style="width:100%;">
                    <thead class="text-center" style="background:grey;color:white;">
                        <th class="text-center">PERMISSIONS LIST&nbsp;:</th>
                        <?php if( isset($all_roles) && is_object($all_roles) ):?>
                            <?php foreach( $all_roles as $item_role):?>
                                <th class="text-center" id="id_role_"<?=$item_role->id;?> data-role-id="<?=$item_role->id;?>"><?=$item_role->name;?></th>
                            <?php endforeach;?>
                        <?php endif;?>
                    </thead>

                    <tbody>
                    <?php if( isset($all_permissions) && is_object($all_permissions) ):?>
                        <?php foreach( $all_permissions as $item_permission):?>
                        <tr class="text-center">
                            <td> <?=$item_permission->name;?> </td>
                            <?php foreach( $all_roles as $item_role):?>
                            <td>
                                <?php if( $item_role->hasPermissions( $item_role->id, $item_permission->name, false ) ):?>
                                    <input type="checkbox" name="<?=$item_role->id;?>[]" value="<?=$item_permission->id;?>" checked />
                                <?php else:?>
                                    <input type="checkbox" name="<?=$item_role->id;?>[]" value="<?=$item_permission->id;?>" />
                                <?php endif;?>
                            </td>
                            <?php endforeach;?>
                        </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_change_permissions" id="btn_submit_change_permissions">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Save change
                    </button>
                </div>
            </div>
        </form>


    </div> <!--/.container-fluid-->
</div> <!--/#article_anchor_section-->
<!-- /Permissions Section -->
