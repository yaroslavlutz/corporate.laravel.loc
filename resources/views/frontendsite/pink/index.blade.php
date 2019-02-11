@extends('layouts.main_layout_site_pink')

@section('header')
    @include('frontendsite.'.env('THEME').'.header')
@endsection

@section('slider_carousel')
    @include('frontendsite.'.env('THEME').'.include._slider_carousel_bootstrap')
@endsection

@section('content')
    <?=$vars_for_template_view['page_content'];?>
    {{--OR: {!! $vars_for_template_view['home_content'] !!} --}}
@endsection

@section('footer')
    @include('frontendsite.'.env('THEME').'.footer')
@endsection
