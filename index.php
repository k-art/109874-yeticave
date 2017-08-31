<?php
require_once ('templates/data.php');
require_once('functions.php');

$data = [
    'categories' => $categories,
    'lots' => $lots,
    'user_name' => $user_name,
    'title' => $title,
];


$content = render_template('templates/index.php', $data);
$layout_template = render_template('templates/layout.php', $data);

print ($layout_template);
print ($content);
?>