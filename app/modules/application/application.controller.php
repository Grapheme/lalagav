<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/blog/{slug}', array('as' => 'blog-post', 'uses' => __CLASS__.'@getBlogPost'));
            Route::any('/catalog/purge', array('as' => 'catalog-purge', 'uses' => __CLASS__.'@postCatalogPurge'));
            Route::get('/catalog/{slug}', array('as' => 'catalog-detail', 'uses' => __CLASS__.'@getCatalogDetail'));
            Route::post('/order/make', array('as' => 'catalog-make-order', 'uses' => __CLASS__.'@postOrderMake'));
            Route::get('/order/success', array('as' => 'catalog-order-success', 'uses' => __CLASS__.'@getOrderSuccess'));
        });
    }


    /****************************************************************************/


	public function __construct(){
        #
        $this->pay_types = [
            1 => 'Электронный платеж',
            2 => 'Наложенный платеж',
            3 => 'Курьер (наличный платеж)',
        ];
	}


    public function getBlogPost($slug) {

        $post = Dic::valueBySlugs('blog', $slug);
        #Helper::ta($post);
        $post = DicLib::loadImages($post, 'image_id');
        #Helper::tad($post);

        $prev_post = Dic::valuesBySlug('blog', function($query) use ($post) {
            $query->where('created_at', '<', $post->created_at);
            $query->take(1);
        });
        $prev_post = @$prev_post[0];
        #Helper::tad($prev_post);

        $next_post = Dic::valuesBySlug('blog', function($query) use ($post) {
            $query->where('created_at', '>', $post->created_at);
            $query->take(1);
        });
        $next_post = @$next_post[0];
        #Helper::tad($next_post);

        return View::make(Helper::layout('blog-post'), compact('post', 'prev_post', 'next_post'));
    }


    public function postCatalogPurge() {

        #Helper::tad(Input::all());
        return View::make(Helper::layout(Request::isXmlHttpRequest() ? 'catalog-purge' : 'catalog-list'));
    }


    public function getCatalogDetail($slug) {

        /**
         * Товар
         */
        $product = (new CatalogProduct)
            ->where('catalog_products.id', $slug)
            ->with('meta')
            ->references('meta')
            ->with('category')
            ->first();
        ;
        #Helper::smartQueries(1);
        #Helper::tad($product);

        if (!is_object($product))
            App::abort(404);

        $product->load(['category.products' => function($query) use ($product){
            $query->limit(6);
            $query->where('id', '!=', $product->id);
            $query->with('meta');
        }]);

        #Helper::ta($product);

        $product->extract(1);

        #Helper::tad($product);

        $product = DicLib::loadImages($product, 'image_id');
        $product = DicLib::loadGallery($product, 'gallery_id');
        #$product->extract(1);

        #Helper::tad($product);


        $products = $product->category->products;
        $products = DicLib::loadImages($products, 'image_id');
        #Helper::tad($products);

        return View::make(Helper::layout('catalog-detail'), compact('product', 'products'));
    }


    public function postOrderMake() {

        /*
        Catalog::create_order([
            'client_name' => 'Ivanov Ivan Ivanovich',
            'delivery_info' => 'Russia, Rostov-on-Don, Suvorova st. 52a, office 300',
            'comment' => 'Comment from customer to order',
            'status' => 1,
            'products' => [
                '123_97d170e1550eee4afc0af065b78cda302a97674c' => [
                    'id' => 123,
                    'count' => 1,
                    'price' => 3000,
                    'attributes' => [],
                ],
            ],
        ]);
        */

        /*
        Array
        (
            [12_97d170e1550eee4afc0af065b78cda302a97674c] => 5
            [metrics] =>               Порода:
                      Пол:
                      Обхват шеи:
                      Обхват груди:
                      Длина спины:
                      Обхват передней лапы:
                      От шеи до передней лапы:
                      Между передними лапами:

            [name] => фывчфы
            [email] => sdfsdf@masd.sd
            [address] => фывфы
            [tel] => фывфы
            [pay_type] => 1
        )
        */

        #Helper::ta(Input::all());

        /**
         * Получаем корзину
         */
        CatalogCart::getInstance();
        $goods = CatalogCart::get_full();
        #Helper::ta($goods);

        /**
         * Формируем массив с продуктами
         */
        $products = [];
        if (count($goods)) {
            foreach ($goods as $good_hash => $good) {
                $products[$good_hash] = [
                    'id' => $good->id,
                    'count' => $good->_amount,
                    'price' => $good->price,
                    'attributes' => [],
                ];
            }
        }

        $pay_type = @$this->pay_types[Input::get('pay_type')] ?: NULL;

        /**
         * Формируем окончательный массив для создания заказа
         */
        $order_array = [
            'client_name' => Input::get('name'),
            'delivery_info' => Input::get('address') . ' ' . Input::get('email') . ' ' . Input::get('tel'),
            'comment' => $pay_type . "\n\n" . Input::get('metrics'),
            'status' => 1,
            'products' => $products,
        ];
        #Helper::ta($order_array);

        $order = Catalog::create_order($order_array);

        /*
        $json_request = [];
        $json_request['responseText'] = '';
        $json_request['status'] = FALSE;

        if (is_object($order) && $order->id)
            $json_request['status'] = TRUE;


        return Response::json($json_request, 200);
        */

        if (is_object($order) && $order->id) {

            return Redirect::route('mainpage');
            #return Redirect::route('catalog-order-success');

        } else {

            return URL::previous();
        }
    }

}