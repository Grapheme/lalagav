<?
/**
 * TITLE: Блог - страница записи
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())
<?
$seo = $post->seo;
$page_title = $post->name;
?>

@section('style')
@stop


@section('content')

    <div class="blog-detail">
        <a href="{{ URL::route('page', 'blog') }}" class="return">Вернуться в блог</a>
        <div class="visual-wrapper">
            <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div>
            <div style="background-image:url('{{ is_object($post->image_id) ? $post->image_id->thumb() : '' }}');" class="visual"></div>
        </div>
        <h1>{{ $post->name }}</h1>
        <time datetime="{{ $post->created_at->format('Y-m-d') }}">
            {{ Helper::rdate('j M Y', $post->created_at) }}
            г.
        </time>
        {{ $post->full_text }}
        <div class="nearby">
            @if (isset($prev_post) && is_object($prev_post))
                <a href="{{ URL::route('blog-post', $prev_post->slug) }}" class="prev">
                    <img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-left.svg">
                    <div class="title">Предыдущий пост</div>
                </a>
            @endif
            @if (isset($next_post) && is_object($next_post))
            <a href="{{ URL::route('blog-post', $next_post->slug) }}" class="next">
                <div class="title">Следующий пост</div>
                <img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg">
            </a>
            @endif
        </div>
    </div>

@stop


@section('scripts')
@stop