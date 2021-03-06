<?
/**
 * TITLE: Каталог - список товаров
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
if (isset($page) && is_object($page))
    $seo = $page->seo;

if (Input::get('dbg-page'))
    Helper::tad($page);

/**
 * Подготавливаем запрос для выборки
 */
$categories = new CatalogCategory();
$tbl_cat_category = $categories->getTable();

$categories = $categories
        ->orderBy(DB::raw('-' . $tbl_cat_category . '.lft'), 'DESC') ## 0, 1, 2 ... NULL, NULL
        ->orderBy($tbl_cat_category . '.created_at', 'DESC')
        ->orderBy($tbl_cat_category . '.id', 'DESC')
        ->with('meta')
        ->with('category_attributes_value.attribute')

        /*
        ->inner_join_attr('min_price', function($join, $value){
            $join->on($value, '>', DB::raw(1000));
        })
        */
        #->having('min_price', '>', 100)
        #->having('mainpage', '=', 1)
;

/**
 * Получаем все категории из БД
 */
$categories = $categories->get();
#Helper::smartQueries(1);
#Helper::tad($categories);

#Helper::tad($categories);
$categories = DicLib::extracts($categories, null, true, true);

#Helper::smartQueries(1);
#Helper::ta($categories);
#Helper::tad($categories[1]->attr_value('min_price'));

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

$cat_ids = (array)Input::get('category')
?>
@extends(Helper::layout())


@section('meta_additional')
<?
$params = ['catalog'];
if (Input::get('page') > 1)
    $params['page'] = Input::get('page')
?>
    <link rel="canonical" href="{{ URL::route('page', $params) }}" />
@stop


@section('style')
@stop


@section('content')

    <form action="{{ URL::route('catalog-purge') }}" class="filters">

        @foreach($hierarchy as $element)
            <?
            $cat = isset($categories[$element['id']]) ? $categories[$element['id']] : false;
            $children = isset($element['children']) ? $element['children'] : NULL;
            if (!$cat || !count($children))
                continue;
            ?>
            <div class="group">
                <div class="title">{{ mb_strtoupper($cat->name) }}</div>
                @foreach($children as $child)
                    <?
                    $child_cat = isset($categories[$child['id']]) ? $categories[$child['id']] : false;
                    ?>
                    <label>
                        <input type="checkbox" value="{{ $child_cat->id }}" name="category[]" {{ in_array($child['id'], $cat_ids) ? ' checked' : '' }}>
                        <div class="label">{{ $child_cat->name }}</div>
                    </label>
                @endforeach
            </div>
        @endforeach

    </form>


    <div class="catalog-list">
        @include(Helper::layout('catalog-purge'))
    </div>


@stop


@section('scripts')
@stop