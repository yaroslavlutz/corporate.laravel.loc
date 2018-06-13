<?php
//dump($all_menus);
?>
<h6> &nbsp;&nbsp;<i>Simple example Accordion with jQuery UI plugin:</i></h6>
<div id="accordion">
    <h3>Section 1 <input type="radio" name="check_box_radio" id="checkBox_1" value="1"/> </h3>
    <div>
        <p>
            Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
            ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
            amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
            odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
        </p>
    </div>
    <h3>Section 2 <input type="radio" name="check_box_radio" id="checkBox_2" value="2"/> </h3>
    <div>
        <p>
            Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
            purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
            velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
            suscipit faucibus urna.
        </p>
    </div>
    <h3>Section 3 <input type="radio" name="check_box_radio" id="checkBox_3" value="3"/> </h3>
    <div>
        <p>
            Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
            Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
            ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
            lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
        </p>
        <ul>
            <li>List item one</li>
            <li>List item two</li>
            <li>List item three</li>
        </ul>
    </div>
    <h3>Section 4 <input type="radio" name="check_box_radio" id="checkBox_4" value="4"/> </h3>
    <div>
        <p>
            Cras dictum. Pellentesque habitant morbi tristique senectus et netus
            et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
            faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
            mauris vel est.
        </p>
        <p>
            Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
            Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
            inceptos himenaeos.
        </p>
    </div>
</div>


<div id="block_add_menu" class="block-add-entries">
    <div class="container-fluid">
        <h2 style="color:#43166d;">Add New Item Menu</h2>

        <form class="form-horizontal" name="add_entries_form" action="{{ route('admin_menus_add_new') }}" method="post" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="menu_title_input" class="control-label col-sm-2">Title of Menu:</label>
                <div class="col-sm-8">
                    <input type="text" name="menu_title_input" id="menu_title_input"  value="{{ old('menu_title_input') }}" class="form-control <?=($errors->has('menu_title_input')) ? 'input-error' : '';?>" placeholder="Title of Menu" />
                    @if ($errors->has('menu_title_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('menu_title_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>
            <div class="form-group">
                <label for="select_nesting_menu_item" class="control-label col-sm-2">Select nesting Menu Item:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="select_nesting_menu_item" id="select_nesting_menu_item">
                        <option value="0"> Parent Item Menu </option> <!--родительский пункт Меню у нас должен иметь `parent_menu_id` = 0 -->
                        <optgroup label="Sub Menu Item for:">
                            <?php foreach( $all_menus as $i_menu ):?>
                            <option value="<?=$i_menu['id'];?>"> <?=$i_menu['title'];?> </option>
                            <?php endforeach;?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="menu_urlpath_input" class="control-label col-sm-2">URL path of Menu:</label>
                <div class="col-sm-8">
                    <input type="text" name="menu_urlpath_input" id="menu_urlpath_input"  value="{{ old('menu_urlpath_input') }}" class="form-control <?=($errors->has('menu_urlpath_input')) ? 'input-error' : '';?>" placeholder="URL path of Menu" />
                    @if ($errors->has('menu_urlpath_input')) <span class="help-block" style="color:darkred;"> {{ $errors->first('menu_urlpath_input') }} </span> @endif  <!--при first() будет выводиться 1-я из валидируемых ошибок для поля, при get() - все -->
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-lg btn-success" name="btn_submit_add_menu_item" id="btn_submit_add_menu_item"">
                        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Add new Item Menu
                    </button>
                </div>
            </div>
        </form>
    </div> <!--/.container-fluid -->
</div>