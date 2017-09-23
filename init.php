<?php
require_once ('config.php');
$error = '';

$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

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
