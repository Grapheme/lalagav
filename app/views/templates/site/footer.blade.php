<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<footer>
    <div class="left">
        <div class="c">© Ляля-гав<br> Ростов-на-Дону, 2015
            <small>год</small>
            <br><a href="tel:+7 (863) 263-81-59">(863) 263-81-59<br></a><a href="mailto:лялягав@mail.ru">лялягав@mail.ru<br></a>
        </div>

        {{ Menu::placement('footer_menu') }}

        {{--
        <ul class="links">
            <li><a href="">Правила и условия</a></li>
            <li><a href="">Политика конфиденциальности</a></li>
            <li><a href="">Чато задаваемые вопросы</a></li>
        </ul>
        --}}
    </div>
    <div class="right">
        <div class="socials">
            <a href="" target="_blank"><img src="{{ Config::get('site.theme_path') }}/images/ico-fb.svg"></a>
            <a href="" target="_blank"><img src="{{ Config::get('site.theme_path') }}/images/ico-insta.svg"></a>
            <a href="" target="_blank"><img src="{{ Config::get('site.theme_path') }}/images/ico-vk.svg"></a>
            <a href="" target="_blank"><img src="{{ Config::get('site.theme_path') }}/images/ico-skype.svg"></a>
        </div>
        <div class="grphm">Сделано в <a href="http://grapheme.ru/" target="_blank">Графема</a></div>
    </div>
    <div class="clrfx"></div>
</footer>
