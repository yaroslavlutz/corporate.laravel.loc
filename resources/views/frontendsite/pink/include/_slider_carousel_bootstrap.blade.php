@section('slider_carousel')

<?php if( isset( $vars_for_template_view['slides'] ) && count($vars_for_template_view['slides']) > 0 && is_array($vars_for_template_view['slides']) ):?>
<div class="container-fluid">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators"> <!--Indicators-->
            <?php for( $i=0, $cnt=count($vars_for_template_view['slides']); $i < $cnt; ++$i ):?>
                <li data-target="#myCarousel" data-slide-to="<?=$i;?>" class="<?=($i == 0) ? 'active' : '';?>"> </li>
            <?php endfor;?>
        </ol> <!--/Indicators-->

        <div class="carousel-inner"> <!--Wrapper for slides-->
            <?php for( $k=0, $cnt=count($vars_for_template_view['slides']); $k < $cnt; ++$k ):?>
                <div id="id_slide_<?=$vars_for_template_view['slides'][$k]['id'];?>" class="item <?=($k == 0) ? 'active' : '';?>">
                    <img src="<?=asset('img/home_slider_images/'.$vars_for_template_view['slides'][$k]['images']);?>" alt="<?=$vars_for_template_view['slides'][$k]['title'];?>" style="width:100%;">
                    <div class="carousel-caption">
                        <h3><?=$vars_for_template_view['slides'][$k]['title'];?></h3>
                        <p><?=$vars_for_template_view['slides'][$k]['desctext'];?></p>
                    </div>
                </div>
            <?php endfor;?>
        </div> <!--/Wrapper for slides-->

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div> <!--.container-fluid-->
<?php endif;?>

@endsection