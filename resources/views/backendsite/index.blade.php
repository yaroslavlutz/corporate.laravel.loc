@extends('layouts.main_layout_admin')

@section('header')
    @include('backendsite.header')
@endsection

@section('content')
    <?=$vars_for_template_view['page_content'];?>
    {{--OR: {!! $vars_for_template_view['home_content'] !!} --}}
@endsection

@section('footer')
    @include('backendsite.footer')
@endsection
