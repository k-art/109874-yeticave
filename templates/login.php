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
    <?php if (!empty($errors)) : ?>
    <form class="form container form--invalid" action="login.php" method="post"> <!-- form--invalid -->
    <?php else : ?>
    <form class="form container" action="login.php" method="post">
    <?php endif; ?>
        <h2>Вход</h2>
        <?php
        if (isset($_GET['new_user']) && $_GET['new_user'] === 'ok') {
            print ('<p>«Теперь вы можете войти, используя свой email и пароль»</p>');
        }
        ?>

        <?php if (!empty($errors['email'])) : ?>
        <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
        <?php else : ?>
        <div class="form__item">
        <?php endif; ?>
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail">
            <?php if (!empty($errors['email'])) : ?>
            <span class="form__error"><?=$errors['email']['message']?></span> <!--Введите e-mail-->
            <?php endif; ?>
        </div>
        <?php if (!empty($errors['password'])) : ?>
        <div class="form__item form__item--last form__item--invalid"> <!-- form__item--invalid -->
        <?php else : ?>
        <div class="form__item form__item--last">
        <?php endif; ?>
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль">
            <?php if (!empty($errors['password'])) : ?>
            <span class="form__error"><?=$errors['password']['message']?></span>
            <?php endif; ?>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>