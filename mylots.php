<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Мои ставки';
$user_bets = [];

if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
}

if (isset($_COOKIE['user_bets'])) {
    $user_bets = json_decode($_COOKIE['user_bets'], true);
}
else {
    $user_bets = [];
}

$content = render_template('mylots', [
    'categories' => $categories,
    'lots' => $lots,
    'user_bets' => $user_bets
]);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);
print ($layout_template);