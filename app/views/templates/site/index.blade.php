<?
/**
 * TITLE: Главная страница
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
/**
 * Подготавливаем запрос для выборки
 */
$categories = new CatalogCategory();
$tbl_cat_category = $categories->getTable();

$categories = $categories
        ->orderBy(DB::raw('-' . $tbl_cat_category . '.lft'), 'DESC') ## 0, 1, 2 ... NULL, NULL
        ->orderBy($tbl_cat_category . '.created_at', 'DESC')
        ->orderBy($tbl_cat_category . '.id', 'DESC')
        #->with('meta')
        ->with(['meta', 'category_attributes_value'])
;

/**
 * Получаем все категории из БД
 */
$categories = $categories->get();
#Helper::tad($categories);
$categories = DicLib::extracts($categories, null, true, true);
$categories = DicLib::loadImages($categories, 'image_id');
#Helper::tad($categories);

/**
 * Строим иерархию
 */
$id_left_right = array();
foreach($categories as $element) {
    $id_left_right[$element->id] = array();
    $id_left_right[$element->id]['left'] = $element->lft;
    $id_left_right[$element->id]['right'] = $element->rgt;
}
$hierarchy = (new NestedSetModel())->get_hierarchy_from_id_left_right($id_left_right);

if ( 0 ) {
    Helper::ta($categories);
    Helper::tad($hierarchy);
}
#die;


/**
 * Костыльное определение минимальной цены товара в каждой категории
 */
$tbl_product = (new CatalogProduct())->getTable();
$tbl_product_meta = (new CatalogProductMeta())->getTable();
$alias = $tbl_product_meta . '2';
$goods = (new CatalogProduct())
        ->includes('meta')
        ->orderBy(DB::raw('CAST(meta.price AS UNSIGNED)'), 'DESC')
        #->groupBy('category_id')
        ->get()
;
#Helper::smartQueries(1);
$goods = DicLib::extracts($goods, null, 1, 1);
#Helper::ta($goods);
$cat_min_prices = Dic::makeLists($goods, null, 'price', 'category_id');
#Helper::tad($cat_min_prices);

?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)
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
    @endif


    @if (isset($hierarchy) && is_array($hierarchy) && count($hierarchy))
        <div class="goods-list"><!--
        @foreach($hierarchy as $element)
            <?
            $cat = isset($categories[$element['id']]) ? $categories[$element['id']] : false;
            $children = isset($element['children']) ? $element['children'] : NULL;
            if (!$cat || !count($children))
                continue;
            ?>
                @foreach($children as $child)
                    <?
                    $child_cat = isset($categories[$child['id']]) ? $categories[$child['id']] : false;
                    #Helper::ta($child_cat);
                    if (!$child_cat->attr_value('mainpage'))
                        continue;
                    ?>
                    --><a href="{{ URL::route('page', ['catalog', 'category' => $child_cat->id]) }}" class="unit">
                        <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
                        <div style="background-image:url('{{ is_object($child_cat->image_id) ? $child_cat->image_id->thumb() : '' }}');" class="visual">
                            <div class="text">
                                <p>{{ mb_strtoupper($child_cat->name) }}</p>
                                @if (isset($cat_min_prices[$child_cat->id]))
                                    <div class="price">от {{ $cat_min_prices[$child_cat->id] }} РУБ. -</div>
                                @endif
                            </div>
                        </div></a><!--
                @endforeach
        @endforeach
        -->
            <div class="clrfx"></div>
        </div>
    @endif


    @if (0)
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
    @endif

    <div class="info-text">
        <div class="text-wrapper">
            <h1>{{ mb_strtoupper($page->h1_or_name()) }}</h1>
            <div class="text">

                {{ $page->block('intro') }}

            </div><img src="{{ Config::get('site.theme_path') }}/images/visual-dog.png" class="visual-dog">
        </div>
    </div>

@stop


@section('scripts')
@stop