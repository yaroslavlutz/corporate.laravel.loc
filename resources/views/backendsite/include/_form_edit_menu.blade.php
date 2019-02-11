<div id="block_edit_menu" class="block-edit-entries">
    <div class="container-fluid">
        <h2 style="color:#43166d;"> <i>Editing the Menu</i> - <?=( isset($current_menu) ) ? '<b>'.$current_menu->title.'</b> (ID:' .$current_menu->id.')' : '';?></h2>

        <form class="form-horizontal" name="edit_entries_form" action="{{ route('admin_menus_update',['menu' => $current_menu->id]) }}" method="post" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT"> 

            <div class="form-group">
                <label for="menu_title_input" class="control-label col-sm-2">Title of Menu:</label>
                <div class="col-sm-8">
                    <input type="text" name="menu_title_input" id="menu_title_input"  value="<?=( isset($current_menu) ) ? $current_menu->title : '';?>" class="form-control <?=($errors->has('menu_title_input')) ? 'input-error' : '';?>" placeholder="Title of Menu" />
                    @if ($errors->has('menu_title_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('menu_title_input') }} </span> @endif  
                </div>
            </div>
            <div class="form-group">
                <label for="select_nesting_menu_item" class="control-label col-sm-2">Select nesting Menu Item:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="select_nesting_menu_item" id="select_nesting_menu_item">
                        <option value="0"> Parent Item Menu </option> 
                        <optgroup label="Sub Menu Item for:">
                            <?php foreach( $result_menu as $i_menu ):?>
                            <option value="<?=$i_menu['id'];?>"  <?=($i_menu['id'] == $current_menu->parent_menu_id) ? 'selected' : '';?>> <?=$i_menu['title'];?> </option>
                            <?php endforeach;?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="menu_urlpath_input" class="control-label col-sm-2">URL path of Menu:</label>
                <div class="col-sm-8">
                    <input type="text" name="menu_urlpath_input" id="menu_urlpath_input"  value="<?=( isset($current_menu) ) ? $current_menu->url_path : '';?>" class="form-control <?=($errors->has('menu_urlpath_input')) ? 'input-error' : '';?>" placeholder="URL path of Menu" />
                    @if ($errors->has('menu_urlpath_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('menu_urlpath_input') }} </span> @endif
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_update_menu" id="btn_submit_update_menu">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Update this Menu Item
                    </button>
                </div>
            </div>
        </form>
    </div> <!--/.container-fluid -->
</div>
