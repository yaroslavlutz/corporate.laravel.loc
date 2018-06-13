<!--прописываем путь к родит.шаблону-МАКЕТУ(Главн.шаблону) `resources/views/layouts/main_layout_site_pink.blade.php` который мы наследуем -->
@extends('layouts.main_layout_site_pink')

@section('header')
    @include('frontendsite.'.env('THEME').'.header')
@endsection

@section('slider_carousel')
    @include('frontendsite.'.env('THEME').'.include._slider_carousel_bootstrap')
@endsection

@section('content')
    <?=$vars_for_template_view['page_content'];?> <!--передается нужная View с нужными данными для динамической секции `content` для той или оной страницы -->
    {{--OR: {!! $vars_for_template_view['home_content'] !!} --}}
@endsection

@section('footer')
    @include('frontendsite.'.env('THEME').'.footer')
@endsection