<?
/**
 * TITLE: Главная страница
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="slider-wrapper">
        <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg">
            <div class="dots"><a href=""></a><a href=""></a><a href=""></a></div>
        </div>
        <div class="slider-holder">
            <ul class="slider-list">
                <li style="background-image:url('{{ Config::get('site.theme_path') }}/images/slide-1.jpg');"></li>
                <li style="background-image:url('http://newsinphoto.ru/wp-content/uploads/2011/01/dogs_1801.jpg');"></li>
                <li style="background-image:url('http://www.formydogs.ru/pics/DSC_0587z.jpg');"></li>
            </ul>
        </div>
    </div>
    <div class="goods-list"><a href="catalog-detail.html" class="unit">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('http://dummyimage.com/752x456');" class="visual">
                <div class="text">
                    <p>НАЦИОНАЛЬНЫЙ КОСТЮМ РУЧНОЙ РАБОТЫ В ТРЕХ ОСНОВНЫХ РОССИЙСКИХ ЦВЕТА</p>
                    <div class="price">600 РУБ. -</div>
                </div>
            </div></a><a href="catalog-detail.html" class="unit new">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('http://dummyimage.com/752x456');" class="visual">
                <div class="text">
                    <p>НАЦИОНАЛЬНЫЙ КОСТЮМ РУЧНОЙ РАБОТЫ В ТРЕХ ОСНОВНЫХ РОССИЙСКИХ ЦВЕТА СНОВНЫХ РОССИЙСКИХ ЦВЕТА</p>
                    <div class="price">600 РУБ. -</div>
                </div>
            </div></a><a href="catalog-detail.html" class="unit">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('http://dummyimage.com/752x456');" class="visual">
                <div class="text">
                    <p>НАЦИОНАЛЬНЫЙ КОСТЮМ РУЧНОЙ РАБОТЫ В ТРЕХ ОСНОВНЫХ РОССИЙСКИХ ЦВЕТА</p>
                    <div class="price">600 РУБ. -</div>
                </div>
            </div></a><a href="catalog-detail.html" class="unit">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('http://dummyimage.com/752x456');" class="visual">
                <div class="text">
                    <p>НАЦИОНАЛЬНЫЙ КОСТЮМ РУЧНОЙ РАБОТЫ В ТРЕХ ОСНОВНЫХ РОССИЙСКИХ ЦВЕТА СНОВНЫХ РОССИЙСКИХ ЦВЕТА</p>
                    <div class="price">600 РУБ. -</div>
                </div>
            </div></a><a href="catalog-detail.html" class="unit">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('http://dummyimage.com/752x456');" class="visual">
                <div class="text">
                    <p>НАЦИОНАЛЬНЫЙ КОСТЮМ РУЧНОЙ РАБОТЫ В ТРЕХ ОСНОВНЫХ РОССИЙСКИХ ЦВЕТА</p>
                    <div class="price">600 РУБ. -</div>
                </div>
            </div></a><a href="catalog-detail.html" class="unit">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('http://dummyimage.com/752x456');" class="visual">
                <div class="text">
                    <p>НАЦИОНАЛЬНЫЙ КОСТЮМ РУЧНОЙ РАБОТЫ В ТРЕХ ОСНОВНЫХ РОССИЙСКИХ ЦВЕТА СНОВНЫХ РОССИЙСКИХ ЦВЕТА</p>
                    <div class="price">600 РУБ. -</div>
                </div>
            </div></a>
        <div class="clrfx"></div>
    </div>
    <div class="info-text">
        <div class="text-wrapper">
            <h1>{{ $page->block('intro', 'name') }}</h1>
            <div class="text">

                {{ $page->block('intro') }}

            </div><img src="{{ Config::get('site.theme_path') }}/images/visual-dog.png" class="visual-dog">
        </div>
    </div>

@stop


@section('scripts')
@stop