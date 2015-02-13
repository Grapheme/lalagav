<?php

class PublicCatalogController extends BaseController {

    public static $name = 'cart';
    public static $group = 'catalog';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;

        /**
         * Добавление товара в корзину (ajax, корзина в сессии)
         */
        Route::post('cart/add', array('as' => $class::$group . '.' . $class::$name . '.add', 'uses' => $class."@postAddToCart"));

        /**
         * Отображение страницы корзины
         */
        Route::get('cart', array('as' => $class::$group . '.' . $class::$name . '.show', 'uses' => $class."@getCart"));

        /**
         * Изменяем кол-во товара в корзине (-1 = удалить позицию)
         */
        Route::post('cart/change-quantity', array('as' => $class::$group . '.' . $class::$name . '.update', 'uses' => $class."@postChangeQuantity"));

        /**
         * Отправка всех данных из корзины и создание нового заказа
         */
        Route::post('checkout/make-order', array('as' => $class::$group . '.' . $class::$name . '.make-order', 'uses' => $class."@postMakeOrder"));

        /**
         * Страница с подтверждением успешного создания заказа
         */
        Route::get('order/success', array('as' => $class::$group . '.' . $class::$name . '.order-success', 'uses' => $class."@getOrderSuccess"));
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
    
	public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group,
            #'tpl' => static::returnTpl('admin/' . self::$name),
            'gtpl' => static::returnTpl(),

            #'entity' => self::$entity,
            #'entity_name' => self::$entity_name,

            'class' => __CLASS__,
        );

        View::share('module', $this->module);
	}


    /**
     * Добавляем товар в корзину
     */
    public function postAddToCart() {

        /*
         * + Добавляем товар(ы) в корзину
         * + Подсчитываем общее кол-во товаров в корзине
         * + Возвращаем JSON-объект
         */

        ## Singleton
        CatalogCart::getInstance();

        $goods = Input::get('goods');
        #Helper::tad($goods);
        if (count($goods)) {
            foreach ($goods as $good_array) {
                $good_id = isset($good_array['id']) && (int)$good_array['id'] > 0 ? (int)$good_array['id'] : NULL;
                if (!$good_id)
                    continue;
                $amount = isset($good_array['amount']) && (int)$good_array['amount'] > 0 ? (int)$good_array['amount'] : 1;
                $options = isset($good_array['options']) && is_array($good_array['count']) ? $good_array['options'] : [];
                CatalogCart::add($good_id, $amount, $options, false);
            }
        }

        ## Debug
        #CatalogCart::add(1, 1, [], false);

        CatalogCart::save();
        $goods_count = CatalogCart::count();

        $json_request = [];
        $json_request['responseText'] = '';
        $json_request['goodsCount'] = $goods_count;
        $json_request['status'] = TRUE;

        #return Response::make(5);
        return Response::json($json_request, 200);
    }


    /**
     * Отображаем страницу корзины
     */
    public function getCart() {

        /*
         * - Получаем все товары из корзины
         * - Отправляем вьюшку с данными
         */

        CatalogCart::getInstance();
        $goods = CatalogCart::get_full();
        #Helper::tad($goods);

        return View::make(Helper::layout('catalog-cart'), compact('goods'));
    }


    public function postChangeQuantity() {

        /**
         * - Ищем товар в БД
         * - Если найден - обновляем кол-во в корзине в соответствии с переданным значением
         * - Если не найден - удаляем позицию из корзины
         * - Получаем текущее состояние корзины
         * - Считаем полную сумму заказа
         * - Возвращаем JSON-объект
         */
        /*
{
  "status": true,
  "items": [
    {
      "id": "id-8",
      "hash": 777
      "amount": 5,
      "price": "1 600",
      "summ": "8 000"
    },
    {
      "id": "id-8",
      "hash": 777888
      "amount": 2,
      "price": "1 600",
      "summ": "3 200"
    }
  ],
  "fullsumm": "11 200"
}
         */

        CatalogCart::getInstance();
        $goods = CatalogCart::get();
        Helper::tad($goods);

        $good = Input::get('good');
        if (isset($good['hash']) && isset($goods[$good['hash']])) {



        }


        $price = null;
        $product = null;
        if (isset($good['id']))
             $product = (new CatalogProduct())->find($good['id']);

        if (is_object($product)) {

            $product->load(['meta']);
            $product->extract(true);
            $price = $product->price ?: null;

        } else {

        }



        $json_request = [];
        $json_request['responseText'] = '';
        $json_request['status'] = TRUE;

        return Response::json($json_request, 200);
    }

    /**
     * Создание нового заказа
     */
    public function postMakeOrder() {

        /*
         * - Создаем новый заказ
         * - Отправляем подтверждение клиенту (To)
         * - Отправляем уведомление менеджеру (To, Cc)
         * - Редирект на страницу подтверждения заказа
         */

        return '';
    }


    /**
     * Страница с подтверждением о создании заказа
     */
    public function getOrderSuccess() {

        /*
         * - Показываем вьюшку
         */
        return '';
    }

}