<?php
require_once ('config.php');

$error = '';

$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE, PORT);
mysqli_set_charset($connect, 'utf8');

if (!$connect) {
    $error = mysqli_connect_error();
    $content = render_template('error', ['categories' => $categories, 'error' => $error]);

    $layout_template = render_template('layout', [
        'title' => 'Проверка соединения',
        'categories' => $categories,
        'content' => $content
    ]);

print ($layout_template);
exit();
}
