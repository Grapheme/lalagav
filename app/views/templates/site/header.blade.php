<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<?
CatalogCart::getInstance();
?>
<header>
    <nav>
        @if (0)
        <ul>
            <li><a href="{{ URL::route('mainpage') }}" class="active"><img src="{{ Config::get('site.theme_path') }}/images/logo_light.svg" class="logo"></a></li>
        </ul>
        @endif

        {{ Menu::placement('main_menu') }}

        {{--
        <ul>
            <li><a href="catalog.html">Каталог</a></li>
            <li><a href="about.html">О нас</a></li>
            <li><a href="blog.html">Блог</a></li>
        </ul>
        --}}
    </nav>
    <div class="right">
        <div class="phone"><a href="tel:+7 (863) 263-81-59">+7 (863) 263-81-59</a></div>
        <a href="{{ URL::route('catalog.cart.show') }}" class="cart">
            <div class="count">{{ CatalogCart::count() }}</div>
            <div class="ico"><img src="{{ Config::get('site.theme_path') }}/images/cart-ico.svg"></div>
        </a>
    </div>
    <div class="clrfx"></div>
</header>
