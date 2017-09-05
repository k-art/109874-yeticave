<main>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="">Доски и лыжи</a>
            </li>
            <li class="nav__item">
                <a href="">Крепления</a>
            </li>
            <li class="nav__item">
                <a href="">Ботинки</a>
            </li>
            <li class="nav__item">
                <a href="">Одежда</a>
            </li>
            <li class="nav__item">
                <a href="">Инструменты</a>
            </li>
            <li class="nav__item">
                <a href="">Разное</a>
            </li>
        </ul>
    </nav>
    <section class="lot-item container">

        <?php
        if (isset($_GET['id']) &&  is_numeric($_GET['id'])) {
            $id = $_GET['id'];
        }
        else {
            http_response_code(404);
        }
        ?>
        <h2><?=$lots[$id]['name']?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lots[$id]['url']?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lots[$id]['category']?></span></p>
                <p class="lot-item__description"><?=$lots[$id]['description']?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        10:54:12
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=$lots[$id]['price']?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span>12 000 р</span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                        <p class="lot-item__form-item">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="number" name="cost" placeholder="12 000">
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <div class="history">
                    <h3>История ставок (<span>4</span>)</h3>

                    <table class="history__list">

                        <?php

                        function format_time ($time_stamp) {
                            $now = strtotime('now');
                            $past_time = $now - $time_stamp ;
                            $time_24h = 86400;
                            $time_1h = 3600;

                            if ($past_time > $time_24h) {
                                return gmdate('d.m.y в H:i', $time_stamp);
                            }
                            elseif ($past_time < $time_1h) {
                                return gmdate('i минут назад', $past_time);
                            }
                            else {
                                return gmdate('G часов назад', $past_time);
                            }
                        }

                        foreach ($bets as $key => $value) : ?>
                            <tr class="history__item">
                                <td class="history__name"><?=$value['name']; ?></td>
                                <td class="history__price"><?=$value['price']; ?> р</td>
                                <td class="history__time"><?=format_time($value['ts']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>