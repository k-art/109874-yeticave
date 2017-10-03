<?php
require_once ('functions.php');
require_once ('init.php');

$title = ' Поиск';
$categories = get_all_categories($connect);
$search = '';
$cur_page = 1;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_value = '%'. $_GET['search'] .'%';
    $search = mysqli_real_escape_string($connect, $search_value);
    if (isset($_GET['page'])) {
        $cur_page = $_GET['page'];
    }
};


$page_items = 3;
$items_count = db_select_data($connect, '
    SELECT COUNT(*) as cnt 
    FROM lots
    WHERE lots.lot_name LIKE ? OR lots.description LIKE ?' , [$search, $search]
);
$pages_count = ceil(intval($items_count[0]['cnt']) / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

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
    WHERE lots.lot_name LIKE ? OR lots.description LIKE ?
    LIMIT ? OFFSET ?', [$search, $search, $page_items, $offset]
);


$pagination = render_template('pagination',
    [
        'pages' => $pages,
        'pages_count' => $pages_count,
        'cur_page' => $cur_page
    ]
);
$content = render_template('search',
    [
        'categories' => $categories,
        'search_lots' => $search_lots,
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
