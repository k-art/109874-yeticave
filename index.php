<?php
require_once ('functions.php');
require_once ('init.php');

$title = 'Главная';
$categories = get_all_categories($connect);
$lots = db_select_data($connect, '
SELECT
  lots.id,
  lots.lot_name,
  lots.init_price,
  lots.lot_image,
  lots.expire_date,
  IFNULL(MAX(bets.price), lots.init_price) as lot_price,
  COUNT(bets.lot_id) as bets_count,
  categories.name as cat_name
FROM lots
JOIN bets
ON bets.lot_id = lots.id
JOIN categories
ON categories.id = lots.category_id
WHERE lots.expire_date > NOW()
GROUP BY lots.id
ORDER BY lots.expire_date DESC;'
);

$cat_class_to_add = ['boards', 'attachment', 'boots', 'clothing', 'tools', 'other'];
$index_data = [
    'categories' => $categories,
    'cat_class_to_add' => $cat_class_to_add,
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
