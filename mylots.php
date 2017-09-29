<?php
require_once ('functions.php');
require_once ('init.php');

$title = 'Мои ставки';
$categories = get_all_categories($connect);
$user_bets = [];
$user_id = null;

if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
}
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
}
$user_bets = db_select_data($connect,"
    SELECT 
      users.id as user_id, 
      bets.price, 
      bets.date,
      lots.lot_name,
      lots.lot_image,
      lots.id as lot_id,
      lots.expire_date,
      categories.name as cat_name
    FROM bets 
    JOIN lots ON bets.lot_id = lots.id
    JOIN users ON users.id = bets.user_id
    JOIN categories ON categories.id = lots.category_id
    WHERE users.id = $user_id
    GROUP BY bets.id
    ORDER BY bets.date DESC"
);

$content = render_template('mylots', [
    'categories' => $categories,
    'user_bets' => $user_bets
]);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);
print ($layout_template);