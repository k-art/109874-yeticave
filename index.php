<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Главная';


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

$index_data = [
    'categories' => $categories,
    'lots' => $lots,
    'lot_time_remaining' => $lot_time_remaining
];

$content = render_template('index', $index_data);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
