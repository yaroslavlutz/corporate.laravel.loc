<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="{{ (isset($meta_description)) ? $meta_description : '' }}">
    <meta name="keywords" content="{{ (isset($keywords)) ? $keywords : '' }}">
    <meta name="author" content="Lutskyi Yaroslav">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="<?=asset('favicon/favicon.ico');?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=asset('favicon/apple-touch-icon.png');?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=asset('favicon/favicon-32x32.png');?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=asset('favicon/favicon-16x16.png');?>">
    <link rel="manifest" href="<?=asset('favicon/site.webmanifest');?>">
    <link rel="mask-icon" href="<?=asset('favicon/safari-pinned-tab.svg');?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>{{ (isset($title)) ? $title : 'Site' }}</title>

    {{--<script src="../../assets/js/ie-emulation-modes-warning.js"></script>--}}

        <!--boot locale CSS-files wow-animation -->
    <link href="<?=asset('wow-animation/animate.min.css');?>" rel="stylesheet" media="screen">
        <!-- boot locale CSS-files of Bootstrap -->
    <link href="<?=asset('bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" media="screen">
        <!-- boot font-awesome Icons -->
    <link href="<?=asset('css/font-awesome.css');?>" rel="stylesheet">
        <!-- boot my custom main CSS-file -->
    <link href="<?=asset('css/style.css');?>" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body data-spy="scroll" data-target=".navbar">

<!-- HEADER -->
<header id="header" class="header">
    @yield('header')
</header>
<!-- /HEADER -->

<!-- SLIDER CAROUSEL -->
<section id="slider_carousel" class="slider_carousel">
@yield('slider_carousel')
</section>
<!-- /SLIDER CAROUSEL -->

<!-- CONTENT -->
<div id="main_wrap_content" class="main-wrap-content">
    @yield('content')
</div>
<!-- /CONTENT -->

<!-- FOOTER -->
<footer id="footer" class="footer">
    @yield('footer')
</footer>
<!-- /FOOTER -->


    <!-- boot locale jQuery library -->
<script src="<?= asset('js/jquery-3.2.1.min.js');?>" type="text/javascript"></script>
    <!-- boot locale js-files wow-animation -->
<script src="<?= asset('wow-animation/wow.min.js');?>" type="text/javascript"></script>
    <!-- boot locale js-files Bootstrap -->
<script src="<?= asset('bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <!-- boot my custom main js-file -->
<script src="<?= asset('js/main.js');?>" type="text/javascript"></script>

<script>
    new WOW().init();
</script>
</body>
</html>
