<main>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="all-lots.html"><?=$categories[0]?></a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html"><?=$categories[1]?></a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html"><?=$categories[2]?></a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html"><?=$categories[3]?></a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html"><?=$categories[4]?></a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html"><?=$categories[5]?></a>
            </li>
        </ul>
    </nav>

    <?php
    // Двойной вопрос мне можно использовать? PhpStorm ругает за ошибку, говорит только в 7й версии
    $lot_name_value = $_POST['name'] ?? '';


    ?>

    <form class="form form--add-lot container" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" required value="<?=$lot_name_value?>">
                <span class="form__error"></span>
            </div>
            <div class="form__item">
                <label for="category">Категория</label>
                <select id="category" name="category" required>
                    <option>Выберите категорию</option>
                    <option><?=$categories[0]?></option>
                    <option><?=$categories[1]?></option>
                    <option><?=$categories[2]?></option>
                    <option><?=$categories[3]?></option>
                    <option><?=$categories[4]?></option>
                    <option><?=$categories[5]?></option>
                </select>
                <span class="form__error"></span>
            </div>
        </div>
        <div class="form__item form__item--wide">
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота" required></textarea>
            <span class="form__error"></span>
        </div>
        <div class="form__item form__item--file"> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0" required>
                <span class="form__error"></span>
            </div>
            <div class="form__item form__item--small">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0" required>
                <span class="form__error"></span>
            </div>
            <div class="form__item">
                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" required>
                <span class="form__error"></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>