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
    <form class="form form--add-lot container form--invalid" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <?php else : ?>
    <form class="form form--add-lot container" action="add.php" method="post" enctype="multipart/form-data">
    <?php endif; ?>
        <h2>Добавление лота</h2>
        <input type="hidden" name="date" value="<?=strtotime('now');?>">
        <div class="form__container-two">

            <?php if (!empty($errors['lot-name'])) : ?>
            <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
            <?php else : ?>
            <div class="form__item">
            <?php endif; ?>
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value=""> <!--required-->
                <span class="form__error">
                    <?php if (isset($errors['lot-name'])) {
                        print $errors['lot-name']['message'];
                    }; ?>
                </span>
            </div>

            <?php if (!empty($errors['category'])) : ?>
            <div class="form__item form__item--invalid">
            <?php else : ?>
            <div class="form__item">
            <?php endif; ?>
                <label for="category">Категория</label>
                <select id="category" name="category" > <!--required-->
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $cat): ?>
                        <?php if ($selected_category === $cat): ?>
                            <option value="<?=$cat['id']?>" selected><?=$cat['name']?></option>
                        <?php else: ?>
                            <option><?=$cat['name']?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">
                    <?php if (isset($errors['category'])) {
                        print $errors['category']['message'];
                    }; ?>
                </span>
            </div>
        </div>

        <?php if (!empty($errors['message'])) : ?>
        <div class="form__item form__item--wide form__item--invalid">
        <?php else : ?>
        <div class="form__item form__item--wide">
        <?php endif; ?>
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота" ></textarea> <!--required-->
            <span class="form__error">
                <?php if (isset($errors['message'])) {
                    print $errors['message']['message'];
                }; ?>
            </span>
        </div>

        <?php if (!empty($errors['lot-image'])) : ?>
        <div class="form__item form__item--file form__item--invalid"> <!--form__item--uploaded-->
        <?php else: ?>
        <div class="form__item form__item--file">
        <?php endif; ?>
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="lot-image" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
                <span class="form__error">
                    <?php if (isset($errors['lot-image'])) {
                        print $errors['lot-image']['message'];
                    }; ?>
                </span>
            </div>
        </div>
        <div class="form__container-three">

            <?php if (!empty($errors['lot-rate'])) : ?>
            <div class="form__item form__item--small form__item--invalid">
            <?php else : ?>
            <div class="form__item form__item--small">
            <?php endif; ?>
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" name="lot-rate" placeholder="0" value=""> <!--type="number" required-->
                <span class="form__error">
                    <?php if (isset($errors['lot-rate'])) {
                        print $errors['lot-rate']['message'];
                    }; ?>
                </span>
            </div>

            <?php if (!empty($errors['lot-step'])) : ?>
            <div class="form__item form__item--small form__item--invalid">
            <?php else : ?>
            <div class="form__item form__item--small">
            <?php endif; ?>
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" name="lot-step" placeholder="0" value=""> <!--type="number" required-->
                <span class="form__error">
                    <?php if (isset($errors['lot-step'])) {
                        print $errors['lot-step']['message'];
                    }; ?>
                </span>
            </div>

            <?php if (!empty($errors['lot-date'])) : ?>
            <div class="form__item form__item--invalid">
            <?php else : ?>
            <div class="form__item">
            <?php endif; ?>
                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" value=""> <!--required-->
                <span class="form__error">
                    <?php if (isset($errors['lot-date'])) {
                        print $errors['lot-date']['message'];
                    }; ?>
                </span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>