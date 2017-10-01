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
    <section class="lot-item container">
        <h2><?=$lot[0]['lot_name']?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot[0]['lot_image']?>" width="730" height="548" alt="<?=$lot[0]['lot_name']?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot[0]['cat_name']?></span></p>
                <p class="lot-item__description"><?=$lot[0]['description']?></p>
            </div>
            <div class="lot-item__right">
                <?php if (isset($_SESSION['user'])) : ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?=set_lot_time_remaining($lot[0]['expire_date']);?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=$lot[0]['lot_price']?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=$lot[0]['bet_step']?></span>
                        </div>
                    </div>
                    <?php if (!is_bet_exist($user_bets, $lot_id)) : ?>
                    <form class="lot-item__form" action="lot.php" method="post">
                        <p class="lot-item__form-item">
                            <?php if (!empty($errors['cost']['message'])) : ?>
                            <label for="cost" style="color: #f84646;"><?=$errors['cost']['message']?></label>
                            <? endif; ?>
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="number" name="cost" placeholder="12 000" value="<?=$lot[0]['lot_price'] + $lot[0]['bet_step']?>">
                            <input type="hidden" name="lot-id" value="<?=$_GET['id']?>">
                            <input type="hidden" name="date" value="<?=strtotime('now');?>">
                            <input type="hidden" name="lot_price" value="<?=$lot[0]['lot_price']?>">
                            <input type="hidden" name="bet_step" value="<?=$lot[0]['bet_step']?>">
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="history">
                    <h3>История ставок (<span><?=$lot[0]['bets_count']?></span>)</h3>

                    <table class="history__list">
                        <?php foreach ($bets as $value) : ?>
                            <tr class="history__item">
                                <td class="history__name"><?=$value['name']; ?></td>
                                <td class="history__price"><?=$value['price']; ?> р</td>
                                <td class="history__time"><?=format_time($value['date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>