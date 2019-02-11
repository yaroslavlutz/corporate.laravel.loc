<!DOCTYPE html>
<?php
//dump($nav_menu);
//dump($vars_for_template_view);
//dump($keywords); dump($meta_description); dump($title);
?>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

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
    <!-- boot locale CSS-files of Bootstrap -->
    <link href="<?=asset('bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" media="screen">
    <!-- boot font-awesome Icons -->
    <link href="<?=asset('css/font-awesome.css');?>" rel="stylesheet">
    <!-- boot locale CSS-file of jQuery UI -->
    <link href="<?=asset('jquery-ui-1.12.1.custom/jquery-ui.min.css');?>" rel="stylesheet">
    <!-- boot my custom main CSS-file -->
    <link href="<?=asset('css/style_admin.css');?>" rel="stylesheet" media="screen">

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
    @if( count($errors) > 0 )
        <div class="alert alert-danger text-center">
            <img src="<?=asset('img/attention.png');?>" alt="" style="display:inline-block; float:left;">
            <ul style="display:inline-block; text-align:left;"> @foreach( $errors->all() as $error ) <li>{{ $error }}</li> @endforeach </ul>
        </div>
    @endif
    @if( session('status') )
        <div class="alert alert-success text-center">
            <i class="fa fa-check" style="font-size:48px; color:green; display:inline-block;"></i>
            <p style="display:inline-block;">{{ session('status') }}</p>
        </div>
    @endif

    @if( session('error') )
        <div class="box error-box">
            <p>{{ session('error') }}</p>
        </div>
    @endif

</header>
<!-- /HEADER -->

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
    <!-- boot locale js-files Ckeditor -->
<script src="<?= asset('ckeditor-4.0.8-standart/ckeditor.js');?>" type="text/javascript"></script>
    <!-- boot locale js-files jQuery UI -->
<script src="<?= asset('jquery-ui-1.12.1.custom/jquery-ui.min.js');?>" type="text/javascript"></script>
    <!-- boot locale js-files Bootstrap -->
<script src="<?= asset('bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <!-- boot locale js-files Bootstrap-filestyle -->
<script src="<?= asset('bootstrap-filestyle-1.2.3/src/bootstrap-filestyle.min.js');?>" type="text/javascript"></script>
    <!-- boot my custom main js-file -->
<script src="<?= asset('js/main_admin.js');?>" type="text/javascript"></script>

</body>
</html>
