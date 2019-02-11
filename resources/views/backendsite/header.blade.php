@section('header')
<div class="container-fluid">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }} Admin Panel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <section id="admin_main_toolbar">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>ADMINISTRATOR PANEL&nbsp;<i class="fa fa-cog fa-spin" style="font-size:40px; color:red;"></i> </h1>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 admin-main-toolbar-nav">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <a data-toggle="collapse" href="#collapse1">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="text-decoration:none; font-weight:bold;"> Open Menu Panel: </h4>
                            </div>
                        </a>
                        <div id="collapse1" class="panel-collapse collapse">
                            <?php if( isset($nav_menu) && is_array($nav_menu) ):?>
                                <ul class="admin-parts-link-list">
                                <?php foreach( $nav_menu as $nav_menu_item ):?>
                                    <?php $index=1;?>
                                    <li id="id_page_<?=$index;?>" data-alias="<?=$nav_menu_item['alias'];?>">
                                        <a href="{{ route('admin_'.$nav_menu_item['alias']) }}" data-toggle="tooltip" data-placement="right" title="Administer&nbsp;<?=$nav_menu_item['title'];?>">
                                            <?=$nav_menu_item['title'];?>
                                        </a>
                                    </li>
                                    <?php $index++;?>
                                <?php endforeach;?>
                                </ul>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div> <!-- /.col-* -->

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 admin-maim-info-container">
                <h4><?=( isset($data_page['title_page']) )
                        ? $data_page['title_page']
                        : '<a type="button" class="btn-info btn-lg" href=" '.route('admin_home').' "><span class="glyphicon glyphicon-th-large"></span> To main Admin Page</a>';?></h4>
            </div>
        </div> <!-- /.row -->
    </section> <!-- /section#admin_main_toolbar -->


</div> <!-- /.container-fluid -->
@endsection
