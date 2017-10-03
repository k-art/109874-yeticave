<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php
            foreach ($categories as $key => $value) : ?>
                <li class="promo__item promo__item--<?=$cat_class_to_add[$key]?>">
                    <a class="promo__link" href="all-lots.php?cat_id=<?= $value['id']; ?>"><?=$value['name']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
            <select class="lots__select" onchange="show_category(this)">
                <option>Все категории</option>
                <?php
                foreach ($categories as $cat) : ?>
                    <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
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
                                <span class="lot__cost"><?=($lot['init_price']); ?><b class="rub">р</b></span>
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
        <?=$pagination; ?>
    </section>
</main>
<script>
    function show_category(element) {
        location.href = "all-lots.php?cat_id=" + element.value;
    }
</script>