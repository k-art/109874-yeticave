<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=filter_content($winner['user_name'])?></p>
<p>Ваша ставка для лота <a href="<?=BASE_URL?>lot.php?id=<?=$winner['lot_id']?>"><?=filter_content($winner['lot_name'])?></a> победила.</p>
<p>Перейдите по ссылке <a href="<?=BASE_URL?>mylots.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>