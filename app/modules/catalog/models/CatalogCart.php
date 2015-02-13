<?php

class CatalogCart {

    private static $session_key = 'catalog.cart';
    private static $goods;
    protected static $_instance = null;

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    protected function __clone() {}
    private function __construct() {
        self::load();
    }


    public static function load() {

        #self::$goods = Session::has(self::$session_key) ? json_decode(Session::get(self::$session_key), true) : [];
        #self::$goods = Session::has(self::$session_key) ? Session::get(self::$session_key)) : [];
        #self::$goods = Session::get(self::$session_key) ?: [];
        self::$goods = Session::get(self::$session_key, []);
        #self::$goods = [];
    }

    public static function save() {

        #Session::put(self::$session_key, json_encode(self::$goods));
        Session::put(self::$session_key, self::$goods);
    }

    public static function get($load = false) {

        if ($load)
            self::load();
        return self::$goods;
    }

    public static function get_full($load = false)
    {

        if ($load)
            self::load();

        #Helper::tad(self::$goods);

        $ids = [];
        if (count(self::$goods))
            $ids = array_keys(self::$goods);

        if (!count($ids))
            return null;

        #Helper::tad($ids);

        $goods = (new CatalogProduct())
            ->whereIn('id', $ids)
            ->with(['meta'])
            ->get();
        if (is_object($goods) && $goods->count()) {
            $goods = DicVal::extracts($goods, null, true, true);
            $goods = DicLib::loadImages($goods, ['image_id']);
        }
        #Helper::tad($goods);

        return $goods;
    }

    public static function count($load = false) {

        if ($load)
            self::load();

        $count = 0;

        foreach (self::$goods as $good_variants) {
            foreach ($good_variants as $good_variant) {
                $count += $good_variant['count'];
            }
        }

        return $count;
    }

    public static function add($good_id, $count = 1, $options = [], $save = false) {

        /**
         * Такая штука: нам нужно хранить свойства покупаемого товара, если они могут различаться.
         * Например, товар разного цвета. Клиент заказывает 1 единицу товара красного цвета и две - черного.
         * По id это один и тот же товар, а свойства и количество - разные.
         */

        /*
         * Если товар с данным id еще не существует в корзине - создадим под него массив
         */
        if (!isset(self::$goods[$good_id]))
            self::$goods[$good_id] = [];

        /*
         * Если в корзине уже есть массив с данными о товаре с таким id -
         * пройдемся по всем элементам массива (группы одного и того же товара, но с разными свойствами),
         * и если найдем совпадение в свойствах с текущим набором - добавим туда текущее кол-во.
         */
        $found = false;
        if (count(self::$goods[$good_id])) {
            /*
             * Ищем группу товаров с подходящими свойствами
             */
            foreach (self::$goods[$good_id] as $g => $good_variant) {
                if ($good_variant['options'] == $options) {
                    $good_variant['count'] += $count;
                    self::$goods[$good_id][$g] = $good_variant;
                    $found = true;
                    break;
                }
            }
        }
        /*
         * Если группа товаров с подходящими свойствами не найдена - добавляем ее
         */
        if (!$found) {
            self::$goods[$good_id][] = [
                'options' => $options,
                'count' => $count,
            ];
        }

        /*
         * Если передана команда о сохранении - сохраняем корзину
         */
        if ($save)
            self::save();

        return true;
    }
}