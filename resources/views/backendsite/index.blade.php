<!--прописываем путь к родит.шаблону-МАКЕТУ(Главн.шаблону) `resources/views/layouts/main_layout_admin.blade.php` который мы наследуем -->
@extends('layouts.main_layout_admin')

@section('header')
    @include('backendsite.header')
@endsection

@section('content')
    <?=$vars_for_template_view['page_content'];?> <!--передается нужная View с нужными данными для динамической секции `content` для той или оной страницы -->
    {{--OR: {!! $vars_for_template_view['home_content'] !!} --}}
@endsection

@section('footer')
    @include('backendsite.footer')
@endsection