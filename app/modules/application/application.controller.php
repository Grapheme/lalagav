<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/blog/{slug}', array('as' => 'blog-post', 'uses' => __CLASS__.'@getBlogPost'));
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
        return View::make(Helper::layout('blog-post'), compact('post'));
    }

}