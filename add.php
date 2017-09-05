<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Добавление лота';
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

$lot_data = [
    'categories' => $categories,
    'lots' => $lots,
    'bets' => $bets
];

//Проверка формы
$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$rules = ['lot-rate', 'lot-step'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && $value == '') {
            $errors[] = $key;
            break;
        }
        if (in_array($key, $rules)) {
            $result = filter_var($value, FILTER_VALIDATE_INT);
            if (!$result) {
                $errors[] = $key;
            }
        }
    }
}
if (!count($errors)) {
    header('Location: /add.php?success=true');
}

if (isset($_GET['success'])) {

    $content = render_template('lot', $lot_data);

    foreach ($_POST as $key => $value) {
        print("Поле $key со значением $value\n");
    }
}
else {
    $content = render_template('add', ['categories' => $categories]);
}


$layout_data = [
    'title' => $title,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);
print ($layout_template);
