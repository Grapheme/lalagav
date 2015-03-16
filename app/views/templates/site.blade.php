<?
/**
 * MENU_PLACEMENTS: main_menu=Основное меню|footer_menu=Меню в подвале
 */
?>
<!DOCTYPE html>
<html class="@yield('page_class') no-js">
<head>
	@include(Helper::layout('head'))

    @section('style')
    @show
</head>
<body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    @include(Helper::layout('header'))

    @section('content')
        {{ @$content }}
    @show

    @section('footer')
        @include(Helper::layout('footer'))
    @show
    @include(Helper::layout('scripts'))

    @section('scripts')
    @show
</body>
</html>