<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $value) : ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=$value?></a>
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
        <?php if (!empty($errors)) : ?>
        <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
        <?php else : ?>
        <div class="form__item">
        <?php endif; ?>
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail">
            <span class="form__error"><?=$err_messages['email']?></span> <!--Введите e-mail-->
        </div>
        <?php if (!empty($errors)) : ?>
        <div class="form__item form__item--last form__item--invalid"> <!-- form__item--invalid -->
        <?php else : ?>
        <div class="form__item form__item--last">
        <?php endif; ?>
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль">
            <span class="form__error"><?=$err_messages['password']?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>