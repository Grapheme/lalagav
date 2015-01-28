<?php
	$presenter = new Illuminate\Pagination\PaginationClass($paginator);
?>
<?php if ($paginator->getLastPage() > 1): ?>
<div class="paginator">
	<a href="?page-prev"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-left.svg"></a>
	<ul class="pages-list">
		{{ $presenter->render() }}
	</ul>
	<a href="?page-next"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"></a>
</div>
<?php endif; ?>