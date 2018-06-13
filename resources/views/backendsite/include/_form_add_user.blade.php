<?php
//dump($all_roles);
?>
<div id="block_add_menu" class="block-add-entries">
    <div class="container-fluid">
        <h2 style="color:#43166d;">Add New User</h2>

        <form class="form-horizontal" name="add_entries_form" action="{{ route('admin_users_add_new') }}" method="post" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="menu_title_input" class="control-label col-sm-2">Name of User:</label>
                <div class="col-sm-8">
                    <input type="text" name="user_name_input" id="user_name_input" value="{{ old('user_name_input') }}" class="form-control <?=($errors->has('user_name_input')) ? 'input-error' : '';?>" placeholder="Name of User" />
                    @if ($errors->has('user_name_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('user_name_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>
            <div class="form-group">
                <label for="user_email_input" class="control-label col-sm-2">E-mail of User:</label>
                <div class="col-sm-8">
                    <input type="email" name="user_email_input" id="user_email_input"  value="{{ old('user_email_input') }}" class="form-control <?=($errors->has('user_email_input')) ? 'input-error' : '';?>" placeholder="E-mail of User" />
                    @if ($errors->has('user_email_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('user_email_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>
            <div class="form-group">
                <label for="user_password_input" class="control-label col-sm-2">Password of User:</label>
                <div class="col-sm-8">
                    <input type="text" name="password" id="user_password_input"  value="{{ old('user_password_input') }}" class="form-control <?=($errors->has('password')) ? 'input-error' : '';?>" placeholder="Password of User" />
                    @if ($errors->has('password')) <span class="help-block" style="color:darkred;"> {{ $errors->first('password') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>
            <div class="form-group">
                <label for="user_password_input_confirmation" class="control-label col-sm-2">Password confirmation:</label>
                <div class="col-sm-8">
                    <input type="text" name="password_confirmation" id="user_password_input_confirmation"  value="{{ old('password_confirmation') }}" class="form-control <?=($errors->has('password_confirmation')) ? 'input-error' : '';?>" placeholder="Password confirmation" />
                    @if ($errors->has('password_confirmation')) <span class="help-block" style="color:darkred;"> {{ $errors->first('password_confirmation') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>
            <div class="form-group">
                <label for="user_password_input_confirmation" class="control-label col-sm-2">Select the roles for User:</label>
                <div class="col-sm-8">
                    <?php foreach( $all_roles as $item_role):?>
                    &nbsp;&nbsp;<input type="checkbox" name="role_id[]" value="<?=$item_role->id;?>" <?=($item_role->name == 'guest')?'checked':'';?> /> <?=$item_role->name;?>
                    <?php endforeach;?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_add_user_item" id="btn_submit_add_user">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add new User
                    </button>
                </div>
            </div>
        </form>
    </div> <!--/.container-fluid -->
</div>