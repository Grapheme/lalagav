<?php namespace Illuminate\Pagination;

class PaginationClass extends Presenter {

	public function getPageLinkWrapper($url, $page, $rel=NULL){
		
		return '<li class="pages-item"><a href="'.$url.'">'.$page.'</a></li>';
	}

	public function getDisabledTextWrapper($text){
		return '<li class="pages-item disabled">'.$text.'</li>';
	}

	public function getActivePageWrapper($text){
		return '<li class="pages-item active">'.$text.'</li>';
	}

}
