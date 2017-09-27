<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $cat) : ?>
                <li class="nav__item">
                    <a href="all-lots.php?cat_id=<?= $cat['id']; ?>"><?=$cat['name']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($user_bets as $bet) : ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?=$lots[$bet['id']]['url']?>" width="54" height="40" alt="<?=$lots[$bet['id']]['name']?>">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?=$bet['id']?>"><?=$lots[$bet['id']]['name']?></a></h3>
                </td>
                <td class="rates__category">
                    <?=$lots[$bet['id']]['category']?>
                </td>
                <td class="rates__timer">
                    <div class="timer timer--finishing"><?=set_lot_time_remaining()?></div>
                </td>
                <td class="rates__price">
                    <?=$bet['cost']?> р
                </td>
                <td class="rates__time">
                    <?=format_time($bet['date'])?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    </section>
</main>