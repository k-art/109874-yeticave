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
    <?php if (!empty($errors)) : ?>
    <form class="form container form--invalid" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <?php else : ?>
    <form class="form container" action="sign-up.php" method="post">
    <?php endif; ?>
        <h2>Регистрация нового аккаунта</h2>
        <input type="hidden" name="date" value="<?=strtotime('now');?>">
        <?php if (!empty($errors['email'])) : ?>
        <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
        <?php else : ?>
        <div class="form__item">
        <?php endif; ?>
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"> <!-- required -->
            <span class="form__error">
                <?php if (isset($errors['email'])) {
                    print $errors['email']['message'];
                }; ?>
            </span>
        </div>
        <?php if (!empty($errors['password'])) : ?>
        <div class="form__item form__item--invalid">
        <?php else : ?>
        <div class="form__item">
        <?php endif; ?>
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль"> <!-- required -->
            <span class="form__error">
                <?php if (isset($errors['password'])) {
                    print $errors['password']['message'];
                }; ?>
            </span>
        </div>
        <?php if (!empty($errors['name'])) : ?>
        <div class="form__item form__item--invalid">
        <?php else : ?>
        <div class="form__item">
        <?php endif; ?>
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя"> <!-- required -->
            <span class="form__error">
                <?php if (isset($errors['name'])) {
                    print $errors['name']['message'];
                }; ?>
            </span>
        </div>
        <?php if (!empty($errors['contacts'])) : ?>
        <div class="form__item form__item--invalid">
        <?php else : ?>
        <div class="form__item">
        <?php endif; ?>
            <label for="contacts">Контактные данные*</label>
            <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться"></textarea> <!-- required -->
            <span class="form__error">
                <?php if (isset($errors['contacts'])) {
                    print $errors['contacts']['message'];
                }; ?>
            </span>
        </div>
        <?php if (!empty($errors['avatar'])) : ?>
        <div class="form__item form__item--file form__item--last form__item--invalid">
        <?php else : ?>
        <div class="form__item form__item--file form__item--last">
        <?php endif; ?>
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="" name="avatar">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        <span class="form__error">
            <?php if (isset($errors['avatar'])) {
                print $errors['avatar']['message'];
            }; ?>
        </span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>