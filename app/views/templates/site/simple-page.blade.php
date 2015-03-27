<?
/**
 * TITLE: Стандартная страница
 */
?>
@extends(Helper::layout())
<?
if (isset($page) && is_object($page))
    $seo = $page->seo;
?>


@section('style')
@stop


@section('content')

    <div class="regular">

        <h1>{{ $page->h1_or_name() }}</h1>

        @if (count($page->blocks))
            @foreach ($page->blocks as $block)
                @if (0)
                    <h2>{{ $page->block($block->slug, 'name') }}</h2>
                @endif
                {{ $page->block($block->slug) }}
            @endforeach
        @endif
    </div>

@stop


@section('scripts')
@stop