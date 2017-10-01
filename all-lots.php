<?php
require_once ('functions.php');
require_once ('init.php');

$title = 'Лоты по категориям';
$categories = get_all_categories($connect);
$errors = [];
$current_cat = null;

if (isset($_GET['cat_id'])) {
    $current_cat = $_GET['cat_id'];
}

$lots = db_select_data($connect, '
SELECT
  lots.id,
  lots.lot_name,
  lots.init_price,
  lots.lot_image,
  lots.expire_date,
  IFNULL(MAX(bets.price), lots.init_price) as lot_price,
  COUNT(bets.lot_id) as bets_count,
  categories.name as cat_name,
  categories.id as cat_id
FROM lots
JOIN bets
ON bets.lot_id = lots.id
JOIN categories
ON categories.id = lots.category_id
WHERE categories.id = ?
GROUP BY lots.id
ORDER BY lots.expire_date;', [$current_cat]
);

$content = render_template('all-lots',
    [
        'categories' => $categories,
        'current_cat' => $current_cat,
        'lots' => $lots,
        'errors' => $errors
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
