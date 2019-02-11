<?php
//dump($current_user);
$roles_user = array();
foreach( $current_user[0]->roles()->get()->toArray() as $user_role ): $roles_user[] = $user_role['id']; endforeach; 
?>
<div id="block_add_menu" class="block-add-entries">
    <div class="container-fluid">
        <h2 style="color:#43166d;"> <i>Editing User</i> - <?=( isset($current_user) ) ? '<b>'.$current_user[0]->name.'</b> (ID:' .$current_user[0]->id.')' : '';?></h2>

        <form class="form-horizontal" name="add_entries_form" action="{{ route('admin_users_update',['id'=>$current_user[0]->id]) }}" method="post" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
                <label for="menu_title_input" class="control-label col-sm-2">Name of User:</label>
                <div class="col-sm-8">
                    <input type="text" name="user_name_input" id="user_name_input" value="<?=( isset($current_user) ) ? $current_user[0]->name : '';?>" class="form-control <?=($errors->has('user_name_input')) ? 'input-error' : '';?>" placeholder="Name of User" />
                    @if ($errors->has('user_name_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('user_name_input') }} </span> @endif 
                </div>
            </div>
            <div class="form-group">
                <label for="user_email_input" class="control-label col-sm-2">E-mail of User:</label>
                <div class="col-sm-8">
                    <input type="email" name="user_email_input" id="user_email_input"  value="<?=( isset($current_user) ) ? $current_user[0]->email : '';?>" class="form-control <?=($errors->has('user_email_input')) ? 'input-error' : '';?>" placeholder="E-mail of User" />
                    @if ($errors->has('user_email_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('user_email_input') }} </span> @endif  
                </div>
            </div>
            <div class="form-group">
                <label for="user_password_input" class="control-label col-sm-2">Password of User:</label>
                <div class="col-sm-8">
                    <input type="password" name="password" id="user_password_input" class="form-control <?=($errors->has('password')) ? 'input-error' : '';?>" placeholder="Password of User" />
                    @if ($errors->has('password')) <span class="help-block" style="color:darkred;"> {{ $errors->first('password') }} </span> @endif
                </div>
            </div>
            <div class="form-group">
                <label for="user_password_input_confirmation" class="control-label col-sm-2">Password confirmation:</label>
                <div class="col-sm-8">
                    <input type="password" name="password_confirmation" id="user_password_input_confirmation" class="form-control <?=($errors->has('password_confirmation')) ? 'input-error' : '';?>" placeholder="Password confirmation" />
                    @if ($errors->has('password_confirmation')) <span class="help-block" style="color:darkred;"> {{ $errors->first('password_confirmation') }} </span> @endif 
                </div>
            </div>
            <div class="form-group">
                <label for="user_password_input_confirmation" class="control-label col-sm-2">Change the roles for User:</label>
                <div class="col-sm-8">
                    <?php foreach( $all_roles as $item_role ):?>
                        <?php if( in_array( $item_role->id, $roles_user ) ):?> 
                            <input type="checkbox" name="role_id[]" value="<?=$item_role->id;?>" checked /> <?=$item_role->name;?> 
                        <?php else:?>
                            <input type="checkbox" name="role_id[]" value="<?=$item_role->id;?>" /> <?=$item_role->name;?>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_edit_user_item" id="btn_submit_edit_user">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Edit User
                    </button>
                </div>
            </div>
        </form>
    </div> <!--/.container-fluid -->
</div>
