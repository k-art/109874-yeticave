<?php
require_once ('functions.php');
require_once ('init.php');

$title = 'Лот';
$categories = get_all_categories($connect);
$lot_id = null;
$lot = '';
$user_id = '';
$bets = '';
$user_bets_data = [];
$cost = '';
$price = null;
$err_message = '';
$user_bets = [];
$is_bet_exist = false;
$validationRules = [
    'cost' => [
        'required',
        'numeric'
    ]
];
$validation_errors = validate_form($validationRules);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
http_response_code(404);
$content = "<h2>Error 404<br>Такой страницы не существует</h2>";
    $layout_data = [
        'title' => $title,
        'categories' => $categories,
        'content' => $content
    ];
    $layout_template = render_template('layout', $layout_data);
    print ($layout_template);
    exit();
}

if (isset($_GET['id'])) {
    $lot_id = intval($_GET['id']);
    $lot = db_select_data($connect,"
        SELECT
          lots.id, 
          lots.lot_name, 
          lots.description, 
          lots.lot_image, 
          lots.expire_date, 
          lots.bet_step, 
          IFNULL(MAX(bets.price), 
          lots.init_price) as lot_price, 
          categories.name as cat_name, 
          COUNT(bets.lot_id) as bets_count
        FROM lots
        JOIN bets ON bets.lot_id = lots.id
        JOIN categories ON categories.id = lots.category_id
        WHERE lots.id = $lot_id
        GROUP BY lots.id");

    $bets = db_select_data($connect,"
        SELECT 
          users.id, 
          users.name, 
          bets.price, 
          bets.date 
        FROM bets 
        JOIN lots ON bets.lot_id = lots.id
        JOIN users ON users.id = bets.user_id
        WHERE lots.id = $lot_id
        GROUP BY bets.id
        ORDER BY bets.date DESC"
    );
}

//if (isset($_COOKIE['user_bets'])) {
//    $user_bets = json_decode($_COOKIE['user_bets'], true);
//}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot_id = $_POST['lot-id'];
    $date = $_POST['date'];

    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];
    }

    $price = $_POST['cost'];

    $last_id = db_insert_data($connect, 'bets', ['user_id' => $user_id, 'lot_id' => $lot_id, 'date' => $date, 'price' => $price]);
    print_r($last_id);


}

//    $id = $_GET['id'];

$content = render_template('lot',
    [
        'categories' => $categories,
        'lot' => $lot,
        'bets' => $bets,
        'id' => $lot_id,
        'validation_errors' => $validation_errors,
        'is_bet_exist' => $is_bet_exist,
        'user_bets' => $user_bets
    ]
);

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);
