<?php
require_once('functions.php');

$index_template = render_template('templates/index.php');
$layout_template = render_template('templates/layout.php');

print ($layout_template);
print ($index_template);
?>