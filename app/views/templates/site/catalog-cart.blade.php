<?
/**
 * TITLE: Каталог - Корзина
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <form action="{{ URL::route('catalog-make-order') }}" method="POST" class="cart-detail">
        <h1>Оформление заказа</h1>
        <div class="bar top"><a href="#n-1">Товары в корзине</a><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"><a href="#n-2">Данные питомца</a><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"><a href="#n-3">Контактные данные</a><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"><a href="#n-4">Способ оплаты</a><img src="{{ Config::get('site.theme_path') }}/images/ico-paginator-right.svg"><a href="#n-5">Подтверждение</a></div>
        <section class="n-1">
            <?
            $fullsumm = 0;
            ?>
            @if (count($goods))
                <table data-action="{{ URL::route('catalog.cart.update') }}" data-method="POST" class="cart-goods-list">
                    @foreach ($goods as $good)
                        <?
                        $fullsumm = $good->price * $good->_amount;
                        ?>
                        <tr class="hash-{{ $good->_hash }}">
                            <td class="margin"></td>
                            <td class="visual-wrapper"><a href="{{ URL::route('catalog-detail', [$good->id]) }}" class="unit">
                                    <div class="mask"><img src="{{ Config::get('site.theme_path') }}/images/mask-main-slider.svg"></div></a>
                                <div style="background-image:url('{{ is_object($good->image_id) ? $good->image_id->thumb() : '' }}');" class="visual"></div>
                            </td>
                            <td class="title"><a href="{{ URL::route('catalog-detail', [$good->id]) }}">{{ $good->name }}</a></td>
                            <td class="count">
                                <input value="{{ $good->_amount }}" name="{{ $good->_hash }}" data-id="{{ $good->id }}" data-price="{{ $good->price }}" autocomplete="off">
                            </td>
                            <td class="current-total"><span class="number">{{ number_format($fullsumm, 0, '.', ' ') }}</span>&nbsp;руб.-</td>
                            <td class="del"><a href=""><img src="{{ Config::get('site.theme_path') }}/images/ico-cross-red.svg"></a></td>
                            <td class="margin"></td>
                        </tr>
                    @endforeach
                </table>
                <div class="total"><span class="number">{{ number_format($fullsumm, 0, '.', ' ') }}</span>&nbsp;руб.-</div>
            @else
                Ваша корзина пуста.
            @endif
        </section>
        <section class="n-2">
            <div class="common-form-wrapper">
                <div class="common-form">
                    <p>
                        Для того чтобы "костюмчик сидел" мы рекомендуем снять мерки с вашего питомца.<br>
                        Да, это займет немного времени, но позволит нам выполнить заказ идеально!
                    </p>
                    <p><a href="{{ Config::get('site.theme_path') }}/images/how-to.jpg" class="new-window">Как правильно снять мерки с питомца</a></p>
                    <p>Пожалуйста укажите размеры питомцев в свободной форме или используйте представлнеую заготовку:</p>
<textarea name="metrics">
Порода:
Пол:
Обхват шеи:
Обхват груди:
Длина спины:
Обхват передней лапы:
От шеи до передней лапы:
Между передними лапами:
</textarea>
                </div>
            </div>
        </section>
        <section class="n-3">
            <div class="common-form-wrapper">
                <div class="common-form">
                    <label>
                        <div class="label">Имя, Фамилия</div>
                        <input name="name">
                    </label>
                    <label>
                        <div class="label">E-mail</div>
                        <input name="email">
                    </label>
                    <label>
                        <div class="label">Адрес доставки</div>
                        <textarea name="address"></textarea>
                    </label>
                    <label>
                        <div class="label">Телефон</div>
                        <input name="tel">
                    </label>
                </div>
            </div>
        </section>
        <section class="n-4">
            <div class="common-form-wrapper">
                <div class="common-form">
                    <p>
                        Мастерская &laquo;Ляля гав&raquo; осуществляет доставку
                        товара почтой в&nbsp;любой регион России.
                        Отправка заказа производится в&nbsp;течение 3 дней.
                        При заказе одновременно трех и&nbsp;более моделей пересылка осуществляется бесплатно.
                    </p>
                    <div class="pay-types">
                        <label>
                            <input type="radio" name="pay_type" value="1">
                            <div class="label-wrapper">
                                <div class="ico"> <img src="{{ Config::get('site.theme_path') }}/images/ico-visa.svg"></div>
                                <div class="label">
                                    <div class="title">Электронный платеж</div>
                                    <div class="desc">
                                        - Доставка по всей России<br>
                                        - Стоимость 150 руб<br>
                                        - Предоплата
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="pay_type" value="2">
                            <div class="label-wrapper">
                                <div class="ico"><img src="{{ Config::get('site.theme_path') }}/images/ico-russiapost.svg"></div>
                                <div class="label">
                                    <div class="title">Наложенный платеж</div>
                                    <div class="desc">
                                        - Доставка по всей России<br>
                                        - Стоимость 123 руб
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="pay_type" value="3">
                            <div class="label-wrapper">
                                <div class="ico"><img src="{{ Config::get('site.theme_path') }}/images/ico-curier.svg"></div>
                                <div class="label">
                                    <div class="title">Курьер (наличный платеж)</div>
                                    <div class="desc">
                                        - Доставка по г. Ростов-на-Дону<br>
                                        - Стоимость 100 руб<br>
                                        - Доставка до двери
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </section>
        <section class="n-5">
            <div class="confirmation">
                <section class="consist">
                    <h3>Состав заказа</h3>
                    <div class="row">
                        <div class="key">Платье тайландское:</div>
                        <div class="val">1 шт. Х 1 600 РУБ.-</div>
                    </div>
                    <div class="row">
                        <div class="key">Национальный костюм в трех основных Россиских цвета:</div>
                        <div class="val">2 шт. Х 1 600 РУБ.-</div>
                    </div>
                </section>
                <section class="contacts">
                    <h3>Контактные данные</h3>
                    <div class="row">
                        <div class="key">ФИО:</div>
                        <div class="val name">Жужам Махмудахмадинеджад Махмудахмадинеджадович</div>
                    </div>
                    <div class="row">
                        <div class="key">E-mail:</div>
                        <div class="val email">Махмудахмад@Yandex.ru</div>
                    </div>
                    <div class="row">
                        <div class="key">Адрес:</div>
                        <div class="val address">Россия, г. Ростов-на-Дону, ул. Каспийская д.35 кв. 9</div>
                    </div>
                    <div class="row">
                        <div class="key">Телефон:</div>
                        <div class="val tel">+7(928)172-39-29</div>
                    </div>
                </section>
                <section class="pet-data">
                    <h3>Данные питомца</h3>
                    <div class="row metrics">
                        Порода: Красный гигант<br>
                        Пол: Кобель<br>
                        Обхват шеи: 900<br>
                        Обхват груди: 670<br>
                        Длина спины: 6<br>
                        Обхват передней лапы: 3,5<br>
                        От шеи до передней лапы: 0<br>
                        Между передними лапами: хвост<br>
                    </div>
                </section>
                <section class="total-conf">
                    <h3>Ваш заказ</h3>
                    <h3 class="numbers">4 923 руб.-</h3>
                    <div class="row full-summ">
                        <div class="key">Сумма заказа</div>
                        <div class="val">4 800 руб.-</div>
                    </div>
                    <div class="row service-summ">
                        <div class="key">Доставка и обслуживание</div>
                        <div class="val">123 руб.-</div>
                    </div>
                </section>
                <center>
                    <button href="final.html" type="submit" class="btn final">Отправить заказ</button>
                </center>
            </div>
        </section>
        <div class="bar bottom"><a href="{{ URL::route('page', 'catalog') }}" class="back">Вернуться в каталог</a><a href="#next" class="btn next">Далее</a>
            <div class="clrfx"></div>
        </div>
    </form>

@stop


@section('scripts')
@stop