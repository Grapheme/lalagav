<?
/**
 * TITLE: Каталог - страница одного товара
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())
<?
$seo = $product->seo;
$page_title = is_object($seo) && $seo->title ? $seo->title : $product->name;
?>


@section('style')
@stop


@section('content')

    <?
    $gallery_exists = false;
    if (isset($product->gallery_id) && is_object($product->gallery_id) && isset($product->gallery_id->photos) && is_object($product->gallery_id->photos) && $product->gallery_id->photos->count()) {
        $gallery_exists = true;
    }
    ?>

    <div class="catalog-detail">
        @if ($gallery_exists || is_object($product->image_id))
        <div class="left">
            <div class="slider-wrapper">
                <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
                <div class="slider-holder">
                    <ul class="slider-list">
                        @if (is_object($product->image_id))
                            <li style="background-image:url('{{ $product->image_id->full() }}');"></li>
                        @endif
                        @if ($gallery_exists)
                            @foreach ($product->gallery_id->photos as $photo)
                            <li style="background-image:url('{{ $photo->full() }}');"></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="thumbs"><!--
                @if (is_object($product->image_id))
                    --><a href="" class="thumb">
                    <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
                    <div style="background-image:url('{{ $product->image_id->thumb() }}');" class="visual"></div></a><!--
                @endif
                @if ($gallery_exists)
                    @foreach ($product->gallery_id->photos as $photo)
                        --><a href="" class="thumb">
                        <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
                        <div style="background-image:url('{{ $photo->thumb() }}');" class="visual"></div></a><!--
                    @endforeach
                @endif
                --></div>
        </div>
        @endif

        <div class="right">
            <h1>{{ $product->name }}</h1>
            <div class="price">{{ $product->price }} Руб.-</div>
            <div class="text">
                <p>{{ $product->description }}</p>
            </div><a href="#" data-href="{{ URL::route('catalog.cart.add') }}" data-id="{{ $product->id }}" class="btn buy">КУПИТЬ</a>
        </div>
        <div class="clrfx"></div>

        @if (isset($products) && is_object($products) && $products->count())
        <div class="recomended">
            <div class="title">Рекомендуем</div>
            <div class="corousel">
                <div class="goods-list-wrapper"><a href="" class="left-arrow"></a>
                    <div class="holder">
                        <div class="goods-list"><!--
                            @foreach ($products as $prod)
                            --><a href="{{ URL::route('catalog-detail', $prod->id) }}" class="unit{{ $prod->attr('default', 'new') ? ' new' : '' }}">
                                <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
                                <div style="background-image:url('{{ is_object($prod->image_id) ? $prod->image_id->thumb() : '' }}');" class="visual">
                                    <div class="text">
                                        <p>{{ $prod->name }}</p>
                                        <div class="price">{{ $prod->price }} РУБ. -</div>
                                    </div>
                                </div>
                            </a><!--
                            @endforeach
                            --><div class="clrfx"></div>
                        </div>
                    </div>
                    <a href="" class="right-arrow"></a>
                </div>
            </div>
        </div>
        @endif

    </div>

@stop


@section('scripts')
@stop