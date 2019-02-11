@section('header')
<?php
$current_route = Route::currentRouteName();
$url_current = \Illuminate\Support\Facades\URL::current();
$url_current_slash = $url_current.'/';
$site_url =  url()->full();
?>

<nav class="navbar navbar-default menu navbar-fixed-top affix-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"> <img src="<?=asset('img/box1_logo.png');?>"> </a> <!--OR:<?//=route('home')?>-->
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if( isset($nav_menu) && is_array($nav_menu) ):?>
                    <?php for( $i=0; $i < count($nav_menu); ++$i ):?>
                        <?php if( !isset($nav_menu[$i]['submenu']) ) {?> 
                            <li id="id_page_<?=$nav_menu[$i]['id'];?>" class="<?=($current_route == $nav_menu[$i]['url_path'] || ($nav_menu[$i]['url_path'] == '/' and $current_route == 'home') ) ? 'active' : '';?>">
                                <?php if( $nav_menu[$i]['url_path'] == '/' ):?> 
                                    <a href="<?=$nav_menu[$i]['url_path'];?>"><?=$nav_menu[$i]['title'];?></a>
                                <?php else: ?>
                                    <a href="{{ route($nav_menu[$i]['url_path']) }}"><?=$nav_menu[$i]['title'];?></a>
                                <?php endif;?>
                            </li>
                        <?php }
                        else { ?>  
                            <li id="id_page_<?=$nav_menu[$i]['id'];?>" class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="<?=$nav_menu[$i]['url_path'];?>"><?=$nav_menu[$i]['title'];?> <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <?php for( $ii=0; $ii < count($nav_menu[$i]['submenu']); ++$ii ):?>
                                        <li> <a href="{{ route('articles_cat', ['cat' => $nav_menu[$i]['submenu'][$ii]['url_path']]) }}"><?=$nav_menu[$i]['submenu'][$ii]['title'];?></a> </li>
                                    <?php endfor;?>
                                </ul>
                            </li>
                        <?php  }?>
                    <?php endfor;?>
                <?php endif;?>

                <li id="" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="" style="text-transform:lowercase; color:blue;">Language <span class="caret"></span> </a>
                    <ul class="dropdown-menu">
                        <li> <a href="{{ route('locale_ru') }}">Русский</a> </li>
                        <li> <a href="{{ route('locale_en') }}">English</a> </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right icons">
                <li><a href="#"> <img src="http://placehold.it/26x27/FF0000/FFFFFF?text= 1"> </a></li>
                <li><a href="#"> <img src="http://placehold.it/26x27/33cc33/FFFFFF?text= 2"> </a></li>
                <li><a href="#"> <img src="http://placehold.it/26x27/0000ff/FFFFFF?text= 3"> </a></li>
                <li><a href="#"> <img src="http://placehold.it/26x27/663300/FFFFFF?text= 4"> </a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
        <i class="glyphicon glyphicon-globe globe"></i>
    </div><!-- /.container -->
</nav>
@endsection
