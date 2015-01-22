<?
/**
 * TITLE: Блог - список записей
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
/**
 * Settings
 */
$per_page = 1;
$page = (int)Input::get('page') ?: 1;

/**
 * Total posts
 */
$total_posts = Dic::valuesBySlugCount('blog', function ($query) {
    $query->where('dic_id', 0);
});
#Helper::tad($total_posts);

/**
 * Get posts of the current page, with pagination
 */
$blog = Dic::valuesBySlug('blog', function ($query) use ($per_page, $page) {
    $query->skip(($page - 1) * $per_page)->take($per_page);
}, ['fields', 'textfields'], true, true, $per_page);
$blog = DicLib::loadImages($blog, 'image_id');
#Helper::tad($blog);
#dd($blog);
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="regular">
        @if (isset($page) && is_object($page) && count($page->blocks))
            @foreach ($page->blocks as $block)
                <h2>{{ $page->block($block->slug, 'name') }}</h2>
                {{ $page->block($block->slug) }}
            @endforeach
        @endif
    </div>

    <div class="blog-list">

        @if (count($blog))
            @foreach ($blog as $post)
                <div class="unit">
                    <a href="{{ URL::route('blog-post', $post->slug) }}" class="visual-wrapper">
                        <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg">
                        </div>
                        <div style="background-image:url('{{ is_object($post->image_id) ? $post->image_id->thumb() : '' }}');" class="visual"></div>
                    </a>

                    <div class="text">
                        <a href="{{ URL::route('blog-post', $post->slug) }}" class="title">
                            <h2>{{ $post->name }}</h2>
                        </a>
                        <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                            {{ Helper::rdate('j M Y', $post->created_at) }}
                            г.
                        </time>
                        <div class="desc">
                            {{ $post->preview }}
                        </div>
                    </div>
                    <div class="clrfx"></div>
                </div>
            @endforeach
        @endif

        <div class="paginator">
            <a href="?page-prev"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-left.svg"></a>
            {{ $blog->links() }}
            <a href="?page-next"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"></a>
        </div>

        <div class="paginator">
            <a href="?page-prev"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-left.svg"></a>
            <a href="?page-1" class="active">1</a><a href="?page-2">2</a><a href="?page-3">3</a><a href="?page-4">4</a><a href="?page-5">5</a><span class="dots">...</span><a href="?page-16">16</a><a href="?page-17">17</a><a href="?page-18">18</a>
            <a href="?page-next"><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"></a>
        </div>

        <div class="clrfx"></div>

    </div>


@stop


@section('scripts')
@stop