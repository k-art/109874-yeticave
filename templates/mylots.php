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
                        <img src="<?=$bet['lot_image']?>" width="54" height="40" alt="<?=$bet['lot_name']?>">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?=$bet['lot_id']?>"><?=$bet['lot_name']?></a></h3>
                </td>
                <td class="rates__category">
                    <?=$bet['cat_name']?>
                </td>
                <td class="rates__timer">
                    <?php if (strtotime($bet['expire_date']) > TIME_24_HOURS) : ?>
                    <div class="timer"><?=set_lot_time_remaining($bet['expire_date'])?></div>
                    <?php else: ?>
                    <div class="timer timer--finishing"><?=set_lot_time_remaining($bet['expire_date'])?></div>
                    <?php endif; ?>
                </td>
                <td class="rates__price">
                    <?=$bet['price']?> р
                </td>
                <td class="rates__time">
                    <?=format_time($bet['date'])?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    </section>
</main>