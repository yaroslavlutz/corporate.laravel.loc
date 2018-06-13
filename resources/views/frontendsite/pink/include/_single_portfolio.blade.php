<?php
//dump($single_portfolio);
?>

<!-- Single portfolio Section -->
<div id="singleportfolio_anchor_section" class="singleportfolio-section" style="margin-top:145px;">
    <div class="container-fluid">
        <h1 class="wow slideInLeft" data-wow-duration="2.5s" data-wow-delay="0.3s" data-wow-offset="120">
            <a href="" style="text-transform:uppercase; color:gray; text-decoration:none;"> <?=$single_portfolio[0]->title;?></a>
        </h1>
        <p class="wow slideInLeft" data-wow-duration="3.5s" data-wow-delay="0.5s" data-wow-offset="120" style="font-size:15px;"> <?=$single_portfolio[0]->title;?> </p>

        <!--Single portfolio-->
        <div class="col-lg-12 col-md-12">

            <?php if( isset($single_portfolio) && is_object($single_portfolio) ): ?>
            <ul id="ul_single_portfolio" class="ul-single-portfolio">
                <li id="li_single_portfolio_id_<?=$single_portfolio[0]->id;?>" class="li-single-portfolio"
                    data-alias="<?=$single_portfolio[0]->alias;?>"
                    data-customer="<?=$single_portfolio[0]->customer;?>"
                    data-portfolio-filter="<?=$single_portfolio[0]->portfolio_filter_alias;?>">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 portfolio-img text-center">
                            <a href=""> <h4 class="text-center"></h4> </a>
                            <img src="<?=asset('img/portfolio_images/'.json_decode($single_portfolio[0]->images)->max);?>" alt="<?=$single_portfolio[0]->alias;?>">
                            <p class="date">
                                <span class="month"><?=date( 'M', strtotime($single_portfolio[0]->created_at) );?></span> <!--date( 'F d, Y' );-->
                                <span class="day"><?=date( 'y', strtotime($single_portfolio[0]->created_at) );?></span>
                            </p>
                        </div>
                        <div class="col-lg-12 col-md-12 portfolio-desc">
                            <div class="portfolio-desc-text"> <p><?=$single_portfolio[0]->text;?></p> </div>
                            <div class="portfolio-panel-info text-center">
                                <ul>
                                    <li>For: <span class="portfolio-user-info"><?=$single_portfolio[0]->customer;?></span> </li>
                                    <a href="{{ route('portfolios_cat', ['alias' => $single_portfolio[0]->PortfolioFilters->alias]) }}"> <li><?=$single_portfolio[0]->PortfolioFilters->title;?></li> </a>
                                    <a href="{{ route('portfolios') }}" type="button" class="btn btn-primary article-btn-readmore">
                                        <?=( App::getLocale() == 'en' ) ? 'See all Portfolios' : trans('custom_ru.all_projects_portfolio');?>
                                    </a>
                                </ul>
                            </div>
                        </div>

                    </div> <!--/.row-->
                </li>
            </ul>
        <?php endif;?>


        </div> <!--/.col-*-->
        <!--Single portfolio-->


    </div> <!--/.container-fluid-->
</div> <!--/#bloglist_anchor_section-->
<!-- /Single portfolio Section -->