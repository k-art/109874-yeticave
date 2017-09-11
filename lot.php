<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Лот';
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
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
