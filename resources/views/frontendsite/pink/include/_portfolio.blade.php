<?php
//dump($list_portfolio);
?>

<!-- PortfolioList Section -->
<div id="portfoliolist_anchor_section" class="portfoliolist-section" style="margin-top:145px;">
    <div class="container-fluid">
        <h1 class="wow slideInLeft" data-wow-duration="2.5s" data-wow-delay="0.3s" data-wow-offset="120">
            <a href="" style="text-transform:uppercase; color:gray; text-decoration:none;"> <?=( App::getLocale() == 'en' ) ? 'Portfolio list' : trans('custom_ru.portfolio_list');?>: </a>
        </h1>
        <p class="wow slideInLeft" data-wow-duration="3.5s" data-wow-delay="0.5s" data-wow-offset="120" style="font-size:15px;">
            <?=( App::getLocale() == 'en' ) ? 'Projects of Portfolio' : trans('custom_ru.all_projects_portfolio');?>:
        </p>

        <!--PortfolioList-->
        <div class="col-lg-12 col-md-12 text-center">
            <?php if( isset($list_portfolio) && is_object($list_portfolio) && count($list_portfolio) ): ?>
            <ul id="ul_portfolio_list" class="ul-portfolio-list">

                <?php $index=0;?>
                <?php foreach( $list_portfolio as $item_portfolio ): ?>
                <li id="li_portfolio_list_id_<?=$item_portfolio->id;?>" class="li-portfolio-list wow <?=($index%2)?'slideInLeft':'slideInRight';?>" data-wow-duration="1.5s" data-wow-delay="0.3s" data-wow-offset="80"
                    data-alias="<?=$item_portfolio->alias;?>"
                    data-customer="<?=$item_portfolio->customer;?>"
                    data-portfolio-filter="<?=$item_portfolio->portfolio_filter_alias;?>">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 portfolio-img">
                            <img src="<?=asset('img/portfolio_images/'.json_decode($item_portfolio->images)->max);?>" alt="<?=$item_portfolio->alias;?>">

                            <span class="portfolio-date-create">
                                <p class="date">
                                    <span class="month"><?=date( 'M', strtotime($item_portfolio->created_at) );?></span> <!--date( 'F d, Y' );-->
                                    <span class="day"><?=date( 'y', strtotime($item_portfolio->created_at) );?></span>
                                </p>
                            </span>
                        </div>
                        <div class="col-lg-5 col-md-5 portfolio-desc">
                            <a href="{{ route('portfolios.show', ['alias' => $item_portfolio->alias]) }}"> <h3><?=$item_portfolio->title;?></h3> </a>
                            <p><?=$item_portfolio->text;?></p>
                            <div class="portfolio-panel-info">
                                <ul>
                                    <li>For: <span class="portfolio-user-info"><?=$item_portfolio->customer;?></span> </li>
                                    <a href="{{ route('portfolios_cat', ['alias' => $item_portfolio->PortfolioFilters->alias]) }}"> <li><?=$item_portfolio->PortfolioFilters->title;?></li> </a>
                                    <a href="{{ route('portfolios.show', ['alias' => $item_portfolio->alias]) }}" type="button" class="btn btn-primary article-btn-readmore">
                                        <?=( App::getLocale() == 'en' ) ? 'Read More' : trans('custom_ru.btn_read_more');?>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div> <!--/.row-->
                </li>
                <?php $index++;?>
                <?php endforeach;?>
            </ul>

            <?php else:?>
            <h2>No Projects in Portfolio!</h2>
            <?php endif;?>
        </div> <!--/.col-*-->
        <!--/PortfolioList-->

        <!--Pagination-->
        <?php if( is_a($list_portfolio, 'Illuminate\Pagination\LengthAwarePaginator') ): ?>
        <div class="row">
        <?php if( $list_portfolio->lastPage() > 1 ): ?> <!--`lastPage()` даст номер последней страницы,кот.определил Laravel для пагинации,и,если она более чем 1, то стоит в принципе ее выводить-->
            <div class="col-lg-12 col-md-12 text-center custom-pagination">{{ $list_portfolio->links() }}</div>
            <?php endif;?>
        </div>
    <?php endif;?>
    <!--/Pagination-->

    </div> <!--/.container-fluid-->
</div> <!--/#portfoliolist_anchor_section-->

<!--/PortfolioList Section -->
