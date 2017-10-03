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

$cur_page = 1;
if (isset($_GET['page'])) {
    $cur_page = $_GET['page'];
}
$page_items = 3;
$items_count = db_select_data($connect, '
    SELECT COUNT(*) 
    as cnt FROM lots
    LEFT JOIN categories
    ON categories.id = lots.category_id
    WHERE categories.id = ?', [$current_cat]
);

$pages_count = ceil(intval($items_count[0]['cnt']) / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

$lots = db_select_data($connect, '
SELECT
  lots.id,
  lots.lot_name,
  lots.init_price,
  lots.lot_image,
  lots.expire_date,
  lots.creation_date,
  IFNULL(MAX(bets.price), lots.init_price) as lot_price,
  COUNT(bets.lot_id) as bets_count,
  categories.name as cat_name,
  categories.id as cat_id
FROM lots
LEFT JOIN bets
ON bets.lot_id = lots.id
LEFT JOIN categories
ON categories.id = lots.category_id
WHERE categories.id = ?
GROUP BY lots.id
ORDER BY lots.creation_date DESC
LIMIT ? OFFSET ?', [$current_cat, $page_items, $offset]
);

$pagination = render_template('pagination',
    [
        'pages' => $pages,
        'pages_count' => $pages_count,
        'cur_page' => $cur_page
    ]
);
$content = render_template('all-lots',
    [
        'categories' => $categories,
        'current_cat' => $current_cat,
        'lots' => $lots,
        'errors' => $errors,
        'pagination' => $pagination
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
