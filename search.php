<?php
require_once ('functions.php');
require_once ('init.php');

$title = ' Поиск';
$categories = get_all_categories($connect);
$search = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_value = '%'. $_GET['search'] .'%';
    $search = mysqli_real_escape_string($connect, $search_value);
};

$search_lots = db_select_data($connect, '
        SELECT 
          lots.id,
          lots.lot_name,
          lots.init_price,
          lots.lot_image,
          lots.expire_date,
          categories.id as cat_id,
          categories.name as cat_name
		FROM lots 
		JOIN categories ON categories.id = lots.category_id
        WHERE lots.lot_name LIKE ? OR lots.description LIKE ?', [$search, $search]);

$content = render_template('search',
    [
        'categories' => $categories,
        'search_lots' => $search_lots
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
