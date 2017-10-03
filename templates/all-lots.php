<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $cat) : ?>
                <li class="nav__item"> <!-- nav__item--current -->
                    <a href="all-lots.php?cat_id=<?= $cat['id']; ?>"><?=$cat['name']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="container">
        <section class="lots">
            <h2>Все лоты в категории <span>«<?=set_category($_GET['cat_id'], $categories)?>»</span></h2>
            <ul class="lots__list">
                <?php
                foreach ($lots as $lot) : ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?=($lot['lot_image']); ?>" width="350" height="260" alt="Сноуборд">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?=$lot['cat_name']; ?></span>
                            <h3 class="lot__title"><a class="text-link" href="<?='lot.php?id=' . $lot['id'];?>"><?=($lot['lot_name']); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?=($lot['init_price']); ?>9<b class="rub">р</b></span>
                                </div>
                                <?php if (strtotime($lot['expire_date']) > TIME_24_HOURS) : ?>
                                    <div class="lot__timer timer">
                                        <?=set_lot_time_remaining($lot['expire_date']);?>
                                    </div>
                                <?php else: ?>
                                    <div class="lot__timer timer timer--finishing">
                                        <?=set_lot_time_remaining($lot['expire_date']);?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</main>