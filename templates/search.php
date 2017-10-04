<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $cat) : ?>
                <li class="nav__item">
                    <a href="all-lots.php?cat_id=<?= $cat['id']; ?>"><?=filter_content($cat['name'])?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?=filter_content($_GET['search'])?></span>»</h2>
            <ul class="lots__list">
            <?php
            foreach ($search_lots as $lot) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?=($lot['lot_image']); ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?=filter_content($lot['cat_name']); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="<?='lot.php?id=' . $lot['id'];?>"><?=filter_content($lot['lot_name']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?=floatval($lot['init_price']); ?><b class="rub">р</b></span>
                            </div>
                            <div class="lot__timer timer">
                                <?=set_lot_time_remaining($lot['expire_date']);?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </section>
    </div>
</main>