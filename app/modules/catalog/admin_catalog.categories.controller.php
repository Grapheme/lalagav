<?php

class AdminCatalogCategoriesController extends BaseController {

    public static $name = 'category';
    public static $group = 'catalog';
    public static $entity = 'category';
    public static $entity_name = 'категория';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        $entity = self::$entity;

        Route::group(array('before' => 'auth', 'prefix' => $prefix . "/" . $class::$group), function() use ($class, $entity) {

            Route::post($class::$name.'/ajax-nested-set-model', array('as' => $class::$group . '.' . $class::$name . '.nestedsetmodel', 'uses' => $class."@postAjaxNestedSetModel"));

            Route::resource($class::$name, $class,
                array(
                    'except' => array('show'),
                    'names' => array(
                        'index'   => $class::$group . '.' . $class::$name . '.index',
                        'create'  => $class::$group . '.' . $class::$name . '.create',
                        'store'   => $class::$group . '.' . $class::$name . '.store',
                        'edit'    => $class::$group . '.' . $class::$name . '.edit',
                        'update'  => $class::$group . '.' . $class::$name . '.update',
                        'destroy' => $class::$group . '.' . $class::$name . '.destroy',
                    )
                )
            );
        });
    }

    ## Shortcodes of module
    public static function returnShortCodes() {
        ##
    }
    
    ## Actions of module (for distribution rights of users)
    public static function returnActions() {
        ##return array();
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
        ##
    }
        
    /****************************************************************************/
    
	public function __construct() {

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group,
            'tpl' => static::returnTpl('admin/' . self::$name),
            'gtpl' => static::returnTpl(),

            'entity' => self::$entity,
            'entity_name' => self::$entity_name,

            'class' => __CLASS__,
        );

        View::share('module', $this->module);
	}

	public function index() {

        Allow::permission($this->module['group'], 'categories_view');

        /**
         * Подготавливаем запрос для выборки
         */
        $elements = new CatalogCategory();
        $tbl_cat_category = $elements->getTable();
        $elements = $elements
            ->orderBy(DB::raw('-' . $tbl_cat_category . '.lft'), 'DESC') ## 0, 1, 2 ... NULL, NULL
            ->orderBy($tbl_cat_category . '.created_at', 'DESC')
            ->orderBy($tbl_cat_category . '.id', 'DESC')
            ->with('meta')
            ->with('products')
            ->with('attributes_groups.attributes')
        ;

        /**
         * Если задана корневая категория - выбираем только ее содержимое
         */
        #/*
        $root_category = null;
        if (NULL !== ($root_id = Input::get('root'))) {
            $root_category = CatalogCategory::find($root_id);
            $root_category->load('meta')->extract(1);
            #Helper::tad($root_category);
            if (is_object($root_category)) {
                $elements = $elements
                    ->where('lft', '>', $root_category->lft)
                    ->where('rgt', '<', $root_category->rgt)
                    ;
            }
        }
        #*/

        /**
         * Получаем все категории из БД
         */
        $elements = $elements->get();
        $elements = DicLib::extracts($elements, null, true, true);
        #Helper::smartQueries(1);
        #Helper::tad($elements);

        /**
         * Строим иерархию
         */
        $id_left_right = array();
        foreach($elements as $element) {
            $id_left_right[$element->id] = array();
            $id_left_right[$element->id]['left'] = $element->lft;
            $id_left_right[$element->id]['right'] = $element->rgt;
        }
        $hierarchy = (new NestedSetModel())->get_hierarchy_from_id_left_right($id_left_right);


        if ( 0 ) {
            Helper::ta($elements);
            Helper::tad($hierarchy);
        }

        $sortable = 9;

        return View::make($this->module['tpl'].'index', compact('elements', 'hierarchy', 'sortable', 'root_category'));
	}

    /************************************************************************************/

	public function create() {

        Allow::permission($this->module['group'], 'categories_create');

        /**
         * Новая (пустая) категория
         */
        $element = new CatalogCategory();

        /**
         * Существующие категории (для списка родителей)
         */
        /**
         * Подготавливаем запрос для выборки
         */
        $elements = new CatalogCategory();
        $tbl_cat_category = $elements->getTable();
        $elements = $elements
            ->orderBy(DB::raw('-' . $tbl_cat_category . '.lft'), 'DESC') ## 0, 1, 2 ... NULL, NULL
            ->orderBy($tbl_cat_category . '.created_at', 'DESC')
            ->orderBy($tbl_cat_category . '.id', 'DESC')
            ->with('meta')
            #->with('products')
            #->with('attributes_groups.attributes')
        ;

        /**
         * Получаем все категории из БД
         */
        $elements = $elements->get();
        $elements = DicLib::extracts($elements, null, true, true);
        #Helper::smartQueries(1);
        #Helper::tad($elements);

        /**
         * Формируем массив с отступами
         */
        $attributes_from_category = NestedSetModel::get_array_for_select($elements);
        $parent_category = ['[нет]'] + $attributes_from_category;
        $attributes_from_category = ['[не копировать]'] + $attributes_from_category;
        #Helper::dd($categories_for_select);

        /**
         * Локали
         */
        $locales = Config::get('app.locales');

		return View::make($this->module['tpl'].'edit', compact('element', 'locales', 'attributes_from_category', 'parent_category'));
	}
    

	public function edit($id) {

        Allow::permission($this->module['group'], 'categories_edit');

		$element = CatalogCategory::where('id', $id)
            ->with(['seos', 'metas', 'meta'])
            ->first()
        ;

        if (!is_object($element))
            App::abort(404);

        if (is_object($element->meta))
            $element->name = $element->meta->name;

        $element->extract();

        $locales = Config::get('app.locales');

        #Helper::tad($element);

        return View::make($this->module['tpl'].'edit', compact('element', 'locales'));
	}


    /************************************************************************************/


	public function store() {

        Allow::permission($this->module['group'], 'categories_create');
		return $this->postSave();
	}


	public function update($id) {

        Allow::permission($this->module['group'], 'categories_edit');
		return $this->postSave($id);
	}


	public function postSave($id = false){

        if (@$id)
            Allow::permission($this->module['group'], 'categories_edit');
        else
            Allow::permission($this->module['group'], 'categories_create');

		if(!Request::ajax())
            App::abort(404);

        if (!$id || NULL === ($element = CatalogCategory::find($id)))
            $element = new CatalogCategory();

        $input = Input::all();

        /**
         * Проверяем системное имя
         */
        if (!trim($input['slug'])) {
            $input['slug'] = $input['meta'][Config::get('app.locale')]['name'];
        }
        $input['slug'] = Helper::translit($input['slug']);

        $slug = $input['slug'];
        $exit = false;
        $i = 1;
        do {
            $test = CatalogCategory::where('slug', $slug)->first();
            #Helper::dd($count);

            if (!is_object($test) || $test->id == $element->id) {
                $input['slug'] = $slug;
                $exit = true;
            } else
                $slug = $input['slug'] . (++$i);

            if ($i >= 10 && !$exit) {
                $input['slug'] = $input['slug'] . '_' . md5(rand(999999, 9999999) . '-' . time());
                $exit = true;
            }

        } while (!$exit);

        /**
         * Проверяем флаг активности
         */
        $input['active'] = @$input['active'] ? 1 : NULL;

        /**
         * Выбрана ли родительская категория
         */
        $parent_cat_id = isset($input['parent_cat_id']) ? $input['parent_cat_id'] : false;
        unset($input['parent_cat_id']);

        /**
         * Выбрана ли категория для копирования набора атрибутов
         */
        $attributes_cat_id = isset($input['attributes_cat_id']) ? $input['attributes_cat_id'] : false;
        unset($input['attributes_cat_id']);

        #Helper::dd($input);
        #Helper::tad($input);

        $json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
        #return Response::json($json_request,200);

        $json_request = array('status' => FALSE, 'responseText' => '', 'responseErrorText' => '', 'redirect' => FALSE);
		$validator = Validator::make($input, array('slug' => 'required'));
		if($validator->passes()) {

            #$redirect = false;

            if ($element->id > 0) {

                $element->update($input);
                $redirect = false;
                $category_id = $element->id;

                /**
                 * Обновим slug на форме
                 */
                if (Input::get('slug') != $input['slug']) {
                    $json_request['form_values'] = array('input[name=slug]' => $input['slug']);
                }

            } else {

                /**
                 * Если выбрана родительская категория, и она найдена в БД...
                 */
                if ($parent_cat_id && NULL !== ($parent_cat = CatalogCategory::find($parent_cat_id))) {

                    #Helper::tad($parent_cat);

                    /**
                     * Поставим новую категорию в конец родительской
                     */
                    $input['lft'] = @(int)$parent_cat->rgt;
                    $input['rgt'] = @(int)$parent_cat->rgt+1;
                    $element->save();

                    /**
                     * Увеличим отступ у всех категорий, следующей за родительской
                     */
                    #CatalogCategory::where('rgt', '>', $parent_cat->rgt)->get();
                    if ($parent_cat->rgt) {
                        DB::update(DB::raw("UPDATE " . $parent_cat->getTable() . " SET lft = lft + 2 WHERE lft > " . $parent_cat->rgt . ""));
                        DB::update(DB::raw("UPDATE " . $parent_cat->getTable() . " SET rgt = rgt + 2 WHERE rgt > " . $parent_cat->rgt . ""));
                    }

                    /**
                     * Увеличим RGT родительской категории на 2
                     */
                    $parent_cat->rgt = $parent_cat->rgt+2;
                    $parent_cat->save();

                } else {

                    /**
                     * Ставим элемент в конец списка
                     */
                    $max_rgt = CatalogCategory::max('rgt');
                    $input['lft'] = @(int)$max_rgt+1;
                    $input['rgt'] = @(int)$max_rgt+2;
                    $element->save();
                }

                $element->update($input);
                $category_id = $element->id;

                $redirect = Input::get('redirect');

                /**
                 * Создаем группу атрибутов по умолчанию
                 */
                $max_rgt = CatalogAttributeGroup::where('category_id', $category_id)->max('rgt');
                $group = CatalogAttributeGroup::create(array(
                    'id' => null,
                    'category_id' => $category_id,
                    'active' => 1,
                    'slug' => 'default',
                    'lft' => @(int)$max_rgt+1,
                    'rgt' => @(int)$max_rgt+2,
                ));
                CatalogAttributeGroupMeta::create(array(
                    'id' => null,
                    'attributes_group_id' => $group->id,
                    'language' => 'ru',
                    'active' => 1,
                    'name' => 'По умолчанию',
                ));
            }


            /**
             * Сохраняем META-данные
             */
            if (
                isset($input['meta']) && is_array($input['meta']) && count($input['meta'])
            ) {
                foreach ($input['meta'] as $locale_sign => $meta_array) {
                    $meta_search_array = array(
                        'category_id' => $category_id,
                        'language' => $locale_sign
                    );
                    $meta_array['active'] = @$meta_array['active'] ? 1 : NULL;
                    $category_meta = CatalogCategoryMeta::firstOrNew($meta_search_array);
                    if (!$category_meta->id)
                        $category_meta->save();
                    $category_meta->update($meta_array);
                    unset($category_meta);
                }
            }

            /**
             * Сохраняем SEO-данные
             */
            if (
                Allow::module('seo')
                && Allow::action('seo', 'edit')
                && Allow::action($this->module['group'], 'categories_seo')
                && isset($input['seo']) && is_array($input['seo']) && count($input['seo'])
            ) {
                foreach ($input['seo'] as $locale_sign => $seo_array) {
                    ## SEO
                    if (is_array($seo_array) && count($seo_array)) {
                        ###############################
                        ## Process SEO
                        ###############################
                        ExtForm::process('seo', array(
                            'module'  => 'CatalogCategory',
                            'unit_id' => $element->id,
                            'data'    => $seo_array,
                            'locale'  => $locale_sign,
                        ));
                        ###############################
                    }
                }
            }

            $json_request['responseText'] = 'Сохранено';
            if ($redirect)
			    $json_request['redirect'] = $redirect;
			$json_request['status'] = TRUE;

		} else {

			$json_request['responseText'] = 'Неверно заполнены поля';
			$json_request['responseErrorText'] = $validator->messages()->all();
		}
		return Response::json($json_request, 200);
	}

    /************************************************************************************/

	public function destroy($id){

        Allow::permission($this->module['group'], 'categories_delete');

		if(!Request::ajax())
            App::abort(404);

		$json_request = array('status' => FALSE, 'responseText' => '');

        $element = CatalogCategory::where('id', $id)->with('attributes_groups.attributes')->first();

        #Helper::tad($element);

        if (is_object($element)) {
            /**
             * Удаление:
             * !! товаров категории,
             * - связок с атрибутами/группами,
             * + SEO-данных,
             * + мета-данных
             * + и самой категории
             */


            /*
            $groups = $element->attributes_groups;
            $attributes = $groups->attributes();
            $groups->delete();
            $attributes->delete();
            */

            if (isset($element->attributes_groups) && is_object($element->attributes_groups) && count($element->attributes_groups)) {

                $groups_ids = array();
                $attributes_ids = array();
                foreach ($element->attributes_groups as $group) {

                    $groups_ids[] = $group->id;

                    if (isset($group->attributes) && is_object($group->attributes) && count($group->attributes)) {
                        foreach ($group->attributes as $attribute) {
                            $attributes_ids[] = $attribute->id;
                        }
                    }
                }

                #Helper::d($groups_ids);
                #Helper::dd($attributes_ids);

                if (count($attributes_ids)) {
                    CatalogAttributeMeta::whereIn('attribute_id', $attributes_ids)->delete();
                    CatalogAttribute::whereIn('id', $attributes_ids)->delete();
                }
                if (count($groups_ids)) {
                    CatalogAttributeGroupMeta::whereIn('attributes_group_id', $groups_ids)->delete();
                    CatalogAttributeGroup::whereIn('id', $groups_ids)->delete();
                }
            }


            if (Allow::module('seo')) {
                Seo::where('module', 'CatalogCategory')
                    ->where('unit_id', $element->id)
                    ->delete()
                ;
            }

            $element->metas()->delete();

            $element->delete();

            /**
             * Сдвигаем категории в общем дереве
             */
            if ($element->rgt) {

                DB::update(DB::raw("UPDATE " . $element->getTable() . " SET lft = lft - 2 WHERE lft > " . $element->lft . ""));
                DB::update(DB::raw("UPDATE " . $element->getTable() . " SET rgt = rgt - 2 WHERE rgt > " . $element->rgt . ""));
            }

            $json_request['responseText'] = 'Удалено';
            $json_request['status'] = TRUE;
        }

		return Response::json($json_request,200);
	}

    public function postAjaxNestedSetModel() {

        #$input = Input::all();

        $data = Input::get('data');
        $data = json_decode($data, 1);
        #Helper::dd($data);

        $offset = 0;
        $root_id = (int)Input::get('root');
        if ($root_id > 0) {
            $root_category = CatalogCategory::find($root_id);
            if (is_object($root_category)) {
                $offset = $root_category->lft;
            }
        }

        if (count($data)) {

            $id_left_right = (new NestedSetModel())->get_id_left_right($data);

            if (count($id_left_right)) {

                $cats = CatalogCategory::whereIn('id', array_keys($id_left_right))->get();

                if (count($cats)) {
                    foreach ($cats as $cat) {
                        $cat->lft = $id_left_right[$cat->id]['left'] + $offset;
                        $cat->rgt = $id_left_right[$cat->id]['right'] + $offset;
                        $cat->save();
                    }
                }
            }
        }

        return Response::make('1');
    }


}


