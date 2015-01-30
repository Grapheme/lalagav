<?
/**
 * TITLE: Служебная. Каталог - список товаров
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<?
/**
 * Settings
 */
$per_page = 2;
#$page = (int)Input::get('page') ?: 1;

/**
 * Get catalog products
 */
$products = (new CatalogProduct)->with('meta', 'values.attribute.group')->with('attributes_groups.attributes')->references('meta');

if (NULL !== ($cat_ids = (array)Input::get('category')) && is_array($cat_ids) && count($cat_ids)) {

    $products = $products->whereIn('category_id', $cat_ids)->orderBy('meta.name', 'asc');

} else {

    $products = $products->orderBy('created_at', 'desc')->orderBy('meta.name', 'asc');
}
$products = $products->paginate($per_page);
#$products = $products->get();
$products = DicLib::extracts($products, null, true, true);
#Helper::tad($products);
$products = DicLib::loadImages($products, 'image_id');
#Helper::smartQueries(1);
#Helper::tad($products);
#dd($products);
?>
@if (isset($products) && is_object($products) && $products->count())
    <div class="goods-list">
        @foreach($products as $product)
            <?
            $new = $product->attr('default', 'new');
            ?>
            <a href="{{ URL::route('catalog-detail', [$product->id]) }}" class="unit{{ $new ? ' new' : '' }}">
                <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
                <div style="background-image:url('{{ is_object($product->image_id) ? $product->image_id->thumb() : '' }}');" class="visual">
                    <div class="text">
                        <p>{{ mb_strtoupper($product->name) }}</p>

                        <div class="price">{{ $product->price }} РУБ. -</div>
                    </div>
                </div>
            </a>
        @endforeach
        <div class="clrfx"></div>
    </div>

    <?
    $products->setBaseUrl(URL::route('catalog-purge'));
    ?>
    {{ $products->links() }}

@endif

@if(0)
    <div class="paginator">
        <a href="?page-prev"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-left.svg"></a><a href="?page-1" class="active">1</a><a href="?page-2">2</a><a href="?page-3">3</a><a href="?page-4">4</a><a href="?page-5">5</a><span class="dots">...</span><a href="?page-16">16</a><a href="?page-17">17</a><a href="?page-18">18</a><a href="?page-next"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"></a>
    </div>
@endif