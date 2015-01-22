<?
/**
 * TITLE: Блог - страница записи
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="blog-detail">
        <a href="{{ URL::to('page', 'blog') }}" class="return">Вернуться в блог</a>
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
            <a href="" class="prev"><img src="images/ico-paginator-left.svg">
                <div class="title">Предыдущий пост</div></a><a href="" class="next">
                <div class="title">Следующий пост</div><img src="images/ico-paginator-right.svg">
            </a>
        </div>
    </div>

@stop


@section('scripts')
@stop