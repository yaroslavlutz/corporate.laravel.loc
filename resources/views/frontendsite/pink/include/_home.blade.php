<?php
//dump($portfolios);
//dump($portfolio_filters);
//dump($right_sidebar_content);

/*Делаем динамическими классы Bootstrap, в зависимости от того передается сюда в макет Side-bar или нет. Если сайт бар определен,то колонки смежной с Side-bar`ом секции будут `9` иначе будут на всю ширину- `12` */
( $right_sidebar_content ) ? $class_num = 9 : $class_num = 12;
?>

<!-- Portfolio Section -->
<div id="portfolio_anchor_section" class="portfolio-section" style="margin-top:22px;">
    <div class="container-fluid">
        <h1 class="wow slideInLeft" data-wow-duration="2.5s" data-wow-delay="0.3s" data-wow-offset="120">
            <a href="" style="text-transform:uppercase; color:gray; text-decoration:none;"> <?=( App::getLocale() == 'en' ) ? 'Portfolio Section' : trans('custom_ru.portfolio_section');?> </a>
        </h1>
        <p class="wow slideInLeft" data-wow-duration="3.5s" data-wow-delay="0.5s" data-wow-offset="120" style="font-size:15px;">
            <?=( App::getLocale() == 'en' ) ? 'That\'s what we did' : trans('custom_ru.what_we_did');?>:
        </p>

        <!--Portfolio Filters-->
        <div class="col-lg-12 col-md-12 col-sm-12 text-center portfolio-filters-block wow fadeInDown" data-wow-delay="0.5s" style="margin-bottom:22px; z-index:2;">
                     <a type="button" href="#filter_0" id="filter_0" class="btn btn-default btn-lg btn-portfolio-filter" style="text-transform:uppercase;">All</a>
            <?php if( isset( $portfolio_filters ) && is_array( $portfolio_filters ) ):?>
                <?php foreach( $portfolio_filters as $portfolio_filter_item ):?>
                    <a type="button" href="#<?=$portfolio_filter_item['alias'];?>" id="<?=$portfolio_filter_item['alias'];?>" class="btn btn-default btn-lg btn-portfolio-filter" style="text-transform:uppercase;"><?=$portfolio_filter_item['title'];?></a>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <!--/Portfolio Filters-->

        <!--Portfolios-->
        <?php if( isset( $portfolios ) && is_array( $portfolios ) ):?>
        <div class="col-lg-<?=$class_num;?> col-md-<?=$class_num;?> text-center">
            <ul>
                <?php for( $i=0, $cnt=count($portfolios); $i < $cnt; ++$i ):?>
                <li id="portfolio_id_<?=$portfolios[$i]['id'];?>" class="portfolio-block" data-alias="<?=$portfolios[$i]['alias'];?>" data-filter="<?=$portfolios[$i]['portfolio_filter_alias'];?>">
                    <ul class="demo-3 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.<?=($i+3)?>s" data-wow-offset="120">
                        <li>
                            <a href="{{ route( 'portfolios.show', ['alias' => $portfolios[$i]['alias']] ) }}"> <!--route( 'portfolios.show', ['portfolio' => $portfolios[$i]['alias']] )-->
                                <figure>
                                    <img src="<?=asset('img/portfolio_images/'.json_decode($portfolios[$i]['images'])->origin);?>" alt="<?=$portfolios[$i]['title'];?>">
                                    <figcaption>
                                        <h2><?=$portfolios[$i]['title'];?></h2>
                                        <p><?=str_limit( $portfolios[$i]['text'], Config::get('settings.limit_description_portfolios_home') );?></p>
                                        <h5>FOR: <?=$portfolios[$i]['customer'];?></h5>
                                    </figcaption>
                                </figure>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endfor;?>
            </ul>
        </div>
        <?php endif;?>
        <!--/Portfolios-->

        <!--Right Side-bar-->
        <?=$right_sidebar_content;?>
        <!--Right Side-bar-->

    </div> <!--/.container-fluid-->
</div> <!--/#services_anchor_section-->
<!-- /Portfolio Section -->
