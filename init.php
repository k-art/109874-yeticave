<?php
require_once ('functions.php');
require_once ('lots_data.php');


$error = '';

$connect = mysqli_connect("localhost", "root", "", "yeticave");

if (!$connect) {
    $error = mysqli_connect_error();
    $content = render_template('error', ['categories' => $categories, 'error' => $error]);
}
else {
    $content = '<h2>Соединение установлено</h2>';
}

$layout_data = [
    'title' => 'Проверка соединения',
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);
print ($layout_template);