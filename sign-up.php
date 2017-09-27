<?php
require_once ('lots_data.php');
require_once ('functions.php');
require_once ('init.php');

$title = 'Регистрация';
$categories = db_select_data($connect, 'SELECT * FROM categories');

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
}

$content = render_template('sign-up',
    [
        'categories' => $categories,
    ]
);

$layout_template = render_template('layout',
    [
        'title' => $title,
        'categories' => $categories,
        'content' => $content
    ]
);

print ($layout_template);
