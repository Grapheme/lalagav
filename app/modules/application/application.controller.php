<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/blog/{slug}', array('as' => 'blog-post', 'uses' => __CLASS__.'@getBlogPost'));
            Route::post('/catalog/purge', array('as' => 'catalog-purge', 'uses' => __CLASS__.'@postCatalogPurge'));
            Route::get('/catalog/{slug}', array('as' => 'catalog-detail', 'uses' => __CLASS__.'@getCatalogDetail'));
        });
    }


    /****************************************************************************/


	public function __construct(){
        #
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
        return View::make(Helper::layout('catalog-purge'));
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

        $product->extract(1);
        $product = DicLib::loadImages($product, 'image_id');
        $product = DicLib::loadGallery($product, 'gallery_id');
        #$product->extract(1);

        #Helper::tad($product);


        $products = $product->category->products;
        $products = DicLib::loadImages($products, 'image_id');
        #Helper::tad($products);

        return View::make(Helper::layout('catalog-detail'), compact('product', 'products'));
    }

}