<?php
$title = 'Главная';

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$is_auth = (bool) rand(0, 1);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
// ...

$lot_time_remaining = gmdate('H:i',$tomorrow - $now);


$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

require_once ('lots_data.php');
require_once ('functions.php');

$index_data = [
    'categories' => $categories,
    'lots' => $lots,
    'lot_time_remaining' => $lot_time_remaining
];

$content = render_template('index', $index_data);

$layout_data = [
    'title' => $title,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
?>