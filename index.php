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
  categories.id as cat_id,
  categories.name as cat_name
FROM lots
LEFT JOIN bets
ON bets.lot_id = lots.id
LEFT JOIN categories
ON categories.id = lots.category_id
WHERE lots.expire_date > NOW()
GROUP BY lots.id
ORDER BY lots.expire_date;'
);

$cat_class_to_add = ['boards', 'attachment', 'boots', 'clothing', 'tools', 'other'];

$content = render_template('index',
    [
        'categories' => $categories,
        'cat_class_to_add' => $cat_class_to_add,
        'lots' => $lots
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
