<?php
return [ //Application settings
    /*Portfolio:*/
    'count_portfolios_home_show' => 9, //кол-во выводимых Портфолио на Главной(Home) странице
    'limit_description_portfolios_home' => 190,  //лимит выводимой строки описания Портфолио на Главной(Home) странице
    'limit_portfolios_show_side_bar' => 5,  //лимит выводимых(последних) Портфолио(работ) в Side-bar
    'portfolios_pagination' => 3,  //пагинация для Portfolio на стр.`../portfolio`
    /*Articles:*/
    'limit_articles_show_side_bar' => 5,  //лимит выводимых(последних) статей(статьи Блога) в Side-bar
    'articles_pagination' => 3,  //пагинация для Blog(Articles) на стр.`../articles`
    'articles_img' => [
        'origin' => ['width'=>960, 'height'=>670], //для получения изображений оригинального размера(хотя судя по всему оригинальное изображение слещдует загружать в оригинальных размерах,т.к.теряются пропорции)
        'mini' => ['width'=>240, 'height'=>320], //для получения изображений минимального размера (preview)
        'max' => ['width'=>1280, 'height'=>960], //для получения изображений максимального размера
    ],
    /*Comments:*/
    'limit_comments_show_side_bar' => 3,  //лимит выводимых(последних) комментариев(на статьи Блога) в Side-bar

];