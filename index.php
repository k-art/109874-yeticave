<?php
require_once ('functions.php');
require_once ('lots_data.php');

$title = 'Главная';

$index_data = [
    'categories' => $categories,
    'lots' => $lots
];

$content = render_template('index', $index_data);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
