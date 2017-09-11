<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Лот';

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';
$is_auth = (bool) rand(0, 1);
$id = '';

$lot_data = [
    'categories' => $categories,
    'lots' => $lots,
    'bets' => $bets,
    'id' => $id
];

$content = render_template('lot', $lot_data);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
