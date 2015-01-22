<?
/**
 * TITLE: Стандартная страница
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="regular">
        @if (count($page->blocks))
            @foreach ($page->blocks as $block)
                <h2>{{ $page->block($block->slug, 'name') }}</h2>
                {{ $page->block($block->slug) }}
            @endforeach
        @endif
    </div>

@stop


@section('scripts')
@stop