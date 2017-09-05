<?php
$title = 'Лот';
// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

require_once ('functions.php');
require_once ('lots_data.php');

$lot_data = [
    'categories' => $categories,
    'lots' => $lots,
    'bets' => $bets
];

$content = render_template('lot', $lot_data);

$layout_data = [
    'title' => $title,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
